<?php

namespace App\Controllers;

use App\Core\Request;
use App\Manager\CommentManager;
use App\Manager\PostManager;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class PostController
 */
class PostController extends AbstractController
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

    /*
     * Fonction ajouter un post
     */
    public function addpost(): string
    {
        global $request;
        $message = null;
        $request = new Request($request->getPostData());

        if ($request->isPost()) {
            $title = $request->get('title');
            $description = $request->get('description');
            $chapo = $request->get('chapo');

            // Utilisez la méthode getSessionData pour obtenir des données de session
            $userId = $request->getSessionData('user_id');

            if (!empty($title) && !empty($description) && !empty($chapo) && !empty($userId)) {
                try {
                    $this->postManager->creatpost($title, $description, $chapo, $userId);
                    $message = 'Article envoyé pour validation';
                } catch (PDOException $e) {
                    $message = 'Une erreur s\'est produite lors de la création de l\'article.';
                }
            }
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

    /*
     * Fonction supprimer un post
     */
    public function delete($id)
    {
        $request = new Request([]);

        $userId = $request->getSessionData('user_id');
        $role = $request->getSessionData('roles') === 'ROLE_ADMIN';

        $post = $this->postManager->fetch($id);
        if ($role || $post->getIdUser() === $userId) {

            $this->postManager->delete($id);

            $this->addSuccess('Suppression réussie');
        } else {
           $this->addError('Vous ne pouvez pas supprimer ce post');
        }

        $this->redirect('/OpenClassrooms/posts');

    }

    /*
     * Fonction modifier un post
     */
    public function update($id)
    {
        $request = new Request($_POST);
        $title = $request->get('title');
        $description = $request->get('description');
        $chapo = $request->get('chapo');

        $post = $this->postManager->fetch($id);
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

    /*
     * Fonction qui affiche tous les posts
     */
    public function list(): string
    {
        $posts = $this->postManager->fetchAll();
        return $this->twig->render('list/list.html.twig', [
            'posts' => $posts
        ]);
    }
}
