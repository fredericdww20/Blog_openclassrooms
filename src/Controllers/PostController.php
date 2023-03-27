<?php

namespace App\Controllers;

use App\Models\PostManager;

class PostController extends Controller
{
	public function addpost()
	{
		if (!empty($_POST))
		{
			$postManager = new PostManager();

			$postManager->creatpost($_POST['title'], $_POST['description'], $_POST['chapo']);

			echo 'Article envoyer';
		}
		return $this->twig->render('addpost/post.html.twig');
	}


}