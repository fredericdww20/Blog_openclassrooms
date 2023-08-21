<?php

namespace App\Controllers;

use App\Models\CommentManager;
use App\Models\PostManager;
use PDOException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CommentController
 */
class CommentController extends Controller
{
    /**
     * @return string
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function addcomment(): string
    {
        if (!empty($_POST['title']) && !empty($_POST['commentary']) && !empty($_POST['id_post'])) {
            $commentManager = new CommentManager();

            $postId = intval($_POST['id_post']);

            // Vérifiez si l'ID de l'utilisateur est défini dans $_SESSION
            if (isset($_SESSION['user_id']) && is_int($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                try {
                    $commentManager->commentate($_POST['title'], $_POST['commentary'], $postId, $userId);
                    $this->addSuccess('Commentaire envoyé');
                } catch (PDOException $e) {
                    $this->addError('Une erreur s\'est produite lors de l\'envoi du commentaire : ' . $e->getMessage());
                }
            }else {
                $this->addError('Veuillez remplir tous les champs du formulaire.');
            }
        } else {
            $this->addError('ID d\'utilisateur invalide.');
        }

        $postManager = new PostManager();
        $post = $postManager->fetch($postId);

        $this->redirect('/OpenClassrooms/post/' . $postId);
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