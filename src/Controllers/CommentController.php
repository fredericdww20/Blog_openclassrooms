<?php

namespace App\Controllers;

use App\Models\CommentManager;

class CommentController extends Controller
{
	public function addcommentay(): string
	{
		$comment = null;
		if (!empty($_POST)) {
			$commentManager = new CommentManager();

			$commentManager->commentate($_POST['title'], $_POST['commentary']);

			$comment = 'Commentaire envoyer pour validation';
		}

		return $this->twig->render('list/post.html.twig', [
			'comment' => $comment
		]);
	}

}