<?php

namespace App\Controllers;

use App\Models\PostManager;

class PostController extends Controller
{
	public function addpost(): string
	{
		$message = null;
		if (!empty($_POST))
		{
			$postManager = new PostManager();

			$postManager->creatpost($_POST['title'], $_POST['description'], $_POST['chapo']);

			$message = 'Article envoyer';
		}
		return $this->twig->render('list/posts.html.twig', [
			'message' => $message
		]);
	}

	public function show($id)
	{
		$postManager = new PostManager();

		$post = $postManager->fetch($id);
		var_dump($post);
		die();

		return $this->twig->render('list/post.html.twig', [
			'post' => $post
		]);
	}

	public function delete($id)
	{
		$postManager = new PostManager();

		$post = $postManager->delete($id);

		return $this->twig->render('list/posts.html.twig', [
			'post' => $post
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