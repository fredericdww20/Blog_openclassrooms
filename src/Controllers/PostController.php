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
			var_dump($_SESSION['id_user']);
			$userId = $_SESSION['id_user'];
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
		$postManager = new PostManager();
		$post = $postManager->fetch($id);

		$message = null;
		$errors = [];

		if (isset($_POST['title'], $_POST['description'], $_POST['chapo'])) {
			$title = $_POST['title'];
			$description = $_POST['description'];
			$chapo = $_POST['chapo'];

			if (empty($title)) {
				$errors[] = 'Le titre est requis.';
			}
			if (empty($description)) {
				$errors[] = 'La description est requise.';
			}
			if (empty($chapo)) {
				$errors[] = 'Le chapo est requis.';
			}

			if (empty($errors)) {
				$postManager->update($id, $title, $description, $chapo);

				$dateUpdated = date('Y-m-d H:i:s');
				$postManager->updateDateUpdated($id, $dateUpdated);

				$message = 'Article modifié';

				header('Location: /OpenClassrooms/post/' . $id . '?message=Article modifié');
				exit();

			} else {
				$errorString = urlencode(implode('<br>', $errors));
				header('Location: /OpenClassrooms/post/' . $id . '?error=' . $errorString);
				exit();
			}
		}


		return $this->twig->render('list/edit.html.twig', [
			'id' => $id,
			'title' => $post->getTitle(),
			'description' => $post->getDescription(),
			'chapo' => $post->getChapo(),
			'message' => $message,
			'errors' => $errors
		]);
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