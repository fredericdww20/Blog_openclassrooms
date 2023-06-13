<?php

namespace App\Controllers;

use App\Models\AdminManager;



class AdminController extends Controller
{

	public function listcomment(): string
	{
		$adminManager = new AdminManager();

		$comments = $adminManager->fetchComment();

		return $this->twig->render('admin/comment.html.twig', [
			'comments' => $comments
		]);
	}

	public function index(): string
	{
		return $this->twig->render('admin/admin.html.twig');
	}

	public function list(): string
	{
		$adminManager = new AdminManager();

		$posts = $adminManager->fetchvalidate();

		return $this->twig->render('admin/posts.html.twig', [
			'posts' => $posts
		]);
	}

	public function update($id)
	{
		$adminManager = new AdminManager();
		$message = null;
		$errors = [];
		$sta = null;

		if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['sta'])) {
				$sta = htmlspecialchars($_POST['sta'], ENT_QUOTES, 'UTF-8');

				if (empty($sta)) {
					$errors[] = 'Le champ "sta" est requis.';
				}

				if (empty($errors)) {
					// Utilisation de requêtes préparées pour l'update
					$adminManager->update($id, $sta);
					$message = 'Mise à jour réussie';

					return $this->twig->render('admin/posts.html.twig', [
						'id' => $id,
						'sta' => $sta,
						'message' => $message,
						'errors' => $errors,
					]);
				}
			}
		}

		return $this->twig->render('admin/edit.html.twig', [
			'id' => $id,
			'sta' => $sta,
			'message' => $message,
			'errors' => $errors,
		]);
	}





}