<?php

namespace App\Controllers;

use App\Models\CommentManager;
use App\Models\PostManager;
use App\Request;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class PostController
 */
class PostController extends Controller
{
    private PostManager $postManager;

    public function __construct()
    {
        $this->postManager = new PostManager();

        parent::__construct();
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function addpost(): string
    {
        $message = null;
        if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['chapo'])) {
            $userId = $_SESSION['user_id'];
            try {
                $this->postManager->creatpost($_POST['title'], $_POST['description'], $_POST['chapo'], $userId);
                $message = 'Article envoyé';
            } catch (PDOException $e) {
                $message = 'Une erreur s\'est produite lors de la création de l\'article.';
            }
        } else {
            $message = 'Veuillez remplir tous les champs du formulaire.';
        }
        return $this->twig->render('list/posts.html.twig', [
            'message' => $message
        ]);
    }


    public function show($id)
    {
        $commentsManager = new CommentManager();
        $post = $this->postManager->fetch($id);
        $comments = $commentsManager->fetch($id);
        return $this->twig->render('list/post.html.twig', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function delete($id)
    {
        $this->postManager->delete($id);
    }

    public function update($id)
    {
        $request = new Request($_POST);
        $title = $request->get('title');
        $description = $request->get('description');
        $chapo = $request->get('chapo');

        $post = $this->postManager->fetch($id);
        $message = null;
        $errors = [];

        if ($request->isPost() && $post) {
            if (!$title) {
                $errors[] = 'Le titre est requis.';
            }
            if (!$description) {
                $errors[] = 'La description est requise.';
            }
            if (!$chapo) {
                $errors[] = 'Le chapo est requis.';
            }

            if (empty($errors)) {
                $this->postManager->update($id, $title, $description, $chapo);
                $message = 'Article modifié';
                $this->redirect('/OpenClassrooms/post/' . $id . '?message=Article modifié');
            } else {
                $errorString = urlencode(implode('<br>', $errors));
                $this->redirect('/OpenClassrooms/post/' . $id . '?error=' . $errorString);
            }
        }
        
        return $this->twig->render('list/edit.html.twig', [
            'post' => $post,
            'message' => $message,
            'errors' => $errors
        ]);
    }

    public function list(): string
    {
        $posts = $this->postManager->fetchAll();
        return $this->twig->render('list/list.html.twig', [
            'posts' => $posts
        ]);
    }
}