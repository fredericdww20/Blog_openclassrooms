<?php

namespace App\Controllers;

use App\Core\Request;
use App\Manager\CommentManager;
use App\Manager\PostManager;
use PDOException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CommentController
 */
class CommentController extends AbstractController
{
    private CommentManager $commentManager;

    public function __construct()
    {
        $this->commentManager = new CommentManager();

        parent::__construct();
    }

    /**
     * @return string
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */

    public function addcomment(): string
    {
        $request = new Request($_POST);

        if (!$request->isPost()) {
            $this->addError('La requête n\'est pas une requête POST.');
            return $this->twig->render('your_template.twig');
        }

        $title = $request->get('title');
        $commentary = $request->get('commentary');
        $id_post = $request->get('id_post');

        if (empty($title) || empty($commentary) || empty($id_post)) {
            $this->addError('Veuillez remplir tous les champs du formulaire.');
            return $this->twig->render('your_template.twig');
        }

        $commentManager = new CommentManager();
        $postManager = new PostManager();

        // Utilisez (int) pour convertir $id_post en entier
        $postId = (int) $id_post;

        $userId = $request->getSessionData('user_id');

        if (!is_int($userId)) {
            $this->addError('ID d\'utilisateur invalide.');
            return $this->twig->render('your_template.twig');
        }

        try {
            $commentManager->commentate($title, $commentary, $postId, $userId);
            $this->addSuccess('Commentaire envoyé');
        } catch (PDOException $e) {
            $this->addError('Une erreur s\'est produite lors de l\'envoi du commentaire : ' . $e->getMessage());
        }

        $this->redirect('/post/' . $postId);
        $this->redirect('/post/' . $postId);
    }



    public function deleteComment($id)
    {
        // Utilisez la classe Request pour obtenir les données de session
        $request = new Request();
        $userId = $request->getSessionData('user_id');
        $roles = $request->getSessionData('roles');

        $post = $this->commentManager->fetchcomment($id);

        if (!$post) {
            $this->addError('Commentaire introuvable.');
            $this->redirect('/post/' . $id);
            return;
        }
        // Vérifier les permissions pour la suppression
        if ($roles === 'ROLE_ADMIN' || $post->getIdUser() === $userId) {
            $this->commentManager->delete($id);
            $this->addSuccess('Suppression réussie');
        } else {
            $this->addError('Vous ne pouvez pas supprimer ce post');
        }

        $postId = $post->getIdPost();
        $postManager = new PostManager();
        $post = $postManager->fetch($postId);
        $this->redirect('/post/' . $postId);
    }

    public function updatecomment($id)
    {
        $request = new Request($_POST);
        $title = $request->get('title');
        $commentary = $request->get('commentary');

        $comment = $this->commentManager->fetchcomment($id);

        $userId = intval($request->getSessionData('user_id')); // Converti en int
        $roles = $request->getSessionData('roles');

        $errors = [];

        if ($request->isPost() && $comment) {
            if (!$title) {
                $errors[] = 'Le titre est requis.';
            }
            if (!$commentary) {
                $errors[] = 'Le commentaire est requis.';
            }

            // Converti l'ID de l'utilisateur du commentaire en int pour la comparaison
            if ($roles !== 'ROLE_ADMIN' && intval($comment->getIdUser()) !== $userId) {
                $errors[] = 'Vous ne pouvez pas mettre à jour ce commentaire';
            }

            if (empty($errors)) {
                $this->commentManager->update($id, $title, $commentary);
                $this->addSuccess('Modification du commentaire validée');
                $this->redirect('/post/' . $comment->getIdPost());
            } else {
                foreach ($errors as $error) {
                    $this->addError($error);
                }
                $this->redirect('/post/' . $comment->getIdPost());
            }
        }

        return $this->twig->render('list/editcomment.html.twig', [
            'comment' => $comment,
        ]);
    }

    public function showComment($id)
    {
        $commentRepository = new CommentManager();

        $comments = $commentRepository->fetch($id);

        return $this->twig->render('list/post.html.twig', [
            'comments' => $comments
        ]);
    }
}
