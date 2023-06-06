<?php

namespace App\Controllers;

use App\Models\CommentManager;
use App\Models\PostManager;

class CommentController extends Controller
{
	public function addcommentay()
	{
		$title = $_POST['title'] ?? '';
		$commentary = $_POST['commentary'] ?? '';
		$postId = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
		$userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

		// Vérifier si l'ID du post existe
		$postManager = new PostManager();
		$post = $postManager->fetch($postId);
		if (!$post) {
			$commenterror = 'Le post n\'existe pas';
			return $this->twig->render('list/posts.html.twig', [
				'commenterror' => $commenterror
			]);
		}

		$commentManager = new CommentManager();

		$commentManager->commentate($title, $commentary, $postId, $userId);

		$comment = 'Commentaire envoyé pour validation';

		return $this->twig->render('list/post.html.twig', [
			'comment' => $comment
		]);
	}


}