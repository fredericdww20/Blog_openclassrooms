<?php

namespace App\Controllers;

use App\Models\PostManager;

class PostController extends Controller
{
	public function addpost(): string
	{
		if (!empty($_POST))
		{
			$postManager = new PostManager();

			$postManager->creatpost($_POST['title'], $_POST['description'], $_POST['chapo']);

			echo 'Article envoyer';
		}
		return $this->twig->render('list/post.html.twig');
	}

	public function show($id)
	{
		return $this->twig->render('list/post.html.twig');
	}

	public function list()
	{
		$postManager = new PostManager();

		//if ($_SESSION['ROLE'] !== 'admin') {
			// redirection vers home
		//	header(' ....');
		//	exit();
		//}

		$posts = $postManager->fetchAll();

		return $this->twig->render('list/list.html.twig', [
			'posts' => $posts
		]);
	}
}