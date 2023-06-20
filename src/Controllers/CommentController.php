<?php

namespace App\Controllers;

use App\Models\CommentManager;
use App\Models\PostManager;

use PDOException;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CommentController extends Controller
{
	public function addcomment(): string
	{
		$message = null;

		if (!empty($_POST['title']) && !empty($_POST['commentary']) && !empty($_POST['id_post'])) {
			$commentManager = new CommentManager();

			$postId = intval($_POST['id_post']);

			// Vérifiez si l'ID de l'utilisateur est défini dans $_SESSION
			if (isset($_SESSION['USER_ID']) && is_int($_SESSION['USER_ID'])) {
				$userId = $_SESSION['USER_ID'];

				try {
					$commentManager->commentate($_POST['title'], $_POST['commentary'], $postId, $userId);
					$message = 'Commentaire envoyé';
				} catch (PDOException $e) {
					$message = 'Une erreur s\'est produite lors de l\'envoi du commentaire : ' . $e->getMessage();
				}
			} else {
				$message = 'ID d\'utilisateur invalide.';
			}
		} else {
			$message = 'Veuillez remplir tous les champs du formulaire.';
		}

		$postManager = new PostManager();
		$post = $postManager->fetch($postId);

		return $this->twig->render('list/post.html.twig', [
			'message' => $message,
			'post' => $post,
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

	public function valisate() {


	}





}