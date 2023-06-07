<?php

namespace App\Controllers;

use App\Models\PostManager;
use App\Models\CommentManager;


class PostController extends Controller
{
	public function addpost(): string
	{
		$message = null;
		if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['chapo'])) {
			$postManager = new PostManager();

			$userId = $_SESSION['USER_ID'];

			try {
				$postManager->creatpost($_POST['title'], $_POST['description'], $_POST['chapo'], $userId);
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
		$postManager = new PostManager();
		$commentsManager = new CommentManager();

		$post = $postManager->fetch($id);

		$comments = $commentsManager->fetch($id);

		return $this->twig->render('list/post.html.twig', [
			'post' => $post,
			'comments' => $comments,
		]);
	}

	public function delete($id)
	{
		$postManager = new PostManager();

		$postManager->delete($id);

	}

	public function update($id)
	{
		if (!empty($_POST)) {

		$postManager = new PostManager();

		$postManager->update($_POST['title'], $_POST['description'], $_POST['chapo'], $_POST['id']);

		}

		return $this->twig->render('list/edit.html.twig');
	}

	public function list(): string
	{
		$postManager = new PostManager();

		$posts = $postManager->fetchAll();

		return $this->twig->render('list/list.html.twig', [
			'posts' => $posts
		]);
	}
}