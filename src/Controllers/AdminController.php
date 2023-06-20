<?php

namespace App\Controllers;

use App\Models\AdminManager;



class AdminController extends Controller
{

	public function listcomment(): string
	{
		$adminManager = new AdminManager();

		$comments = $adminManager->fetchcomment();

		return $this->twig->render('admin/comment.html.twig', [
			'comments' => $comments
		]);
	}

	public function listvalidate(): string
	{
		$adminManager = new AdminManager();

		$posts = $adminManager->fetchAll();

		return $this->twig->render('admin/admin.html.twig', [
			'posts' => $posts
		]);
	}


	public function list(): string
	{
		$adminManager = new AdminManager();

		$posts = $adminManager->fetchvalidate();

		$message = $_SESSION['message'];

		$output = $this->twig->render('admin/posts.html.twig', [
			'posts' => $posts,
			'message' => $message
		]);

		unset($_SESSION['message']);

		return $output;
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

					$adminManager->update($id, $sta);

					$_SESSION['message'] = 'Mise à jour réussie';

					header('Location: /OpenClassrooms/admin/posts');
					exit();
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

	public function updatecomment($id)
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

					$adminManager->updatecomment($id, $sta);

					$_SESSION['message'] = 'Mise à jour réussie';

					header('Location: /OpenClassrooms/admin/comment');
					exit();
				}
			}
		}

		return $this->twig->render('admin/editcomment.html.twig', [
			'id' => $id,
			'sta' => $sta,
			'message' => $message,
			'errors' => $errors,
		]);
	}


}