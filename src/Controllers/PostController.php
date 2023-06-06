<?php

namespace App\Controllers;

use App\Models\PostManager;
use App\Models\CommentManager;


class PostController extends Controller
{
	public function addpost(): string
	{
		$message = null;
		if (!empty($_POST)) {
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

		return $this->twig->render('list/post.html.twig', [
			'post' => $post
		]);
	}

	public function showcomment($id)
	{
		$commentManager = new CommentManager();

		$comment = $commentManager->fetch($id);

		return $this->twig->render('list/post.html.twig', [
			'comment' => $comment
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

		$postManager->update($_POST['title'], $_POST['description'], $_POST['chapo']);

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