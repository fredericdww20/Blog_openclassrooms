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
        if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['chapo'])) {

            $userId = $_SESSION['user_id'];

            try {
                $this->postManager->creatpost($_POST['title'], $_POST['description'], $_POST['chapo'], $userId);
                $this->addSuccess('Article envoyé pour validation');
            } catch (PDOException $e) {
                $this->addError('Une erreur s\'est produite lors de la création de l\'article.');
            }
        } else {
            $this->addError('Veuillez remplir tous les champs.');
        }
        $this->redirect('/OpenClassrooms/add');
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
        $userId = $_SESSION['user_id'];
        $role = $_SESSION['roles'] === 'ROLE_ADMIN';

        $post = $this->postManager->fetch($id);
        if ($role || $post->getIdUser() === $userId) {

            $this->postManager->delete($id);

            $this->addSuccess('Suppression réussie');
        } else {
           $this->addError('Vous ne pouvez pas supprimer ce post');
        }

        $this->redirect('/OpenClassrooms/posts');

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
                $this->addSuccess('Article modifié');
                $this->redirect('/OpenClassrooms/post/' . $id);
            } else {
                $this->addError('Erreur dans la modification du post');
                $this->redirect('/OpenClassrooms/post/' . $id);
            }
        }

        return $this->twig->render('list/edit.html.twig', [
            'post' => $post,
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
