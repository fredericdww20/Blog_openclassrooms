<?php
namespace App\Controllers;

class MainController extends Controller
{
	public function index()
	{
		$posts = $this->postManager->findAll();

		return $this->twig->render('main/index.html.twig', [
			'posts' => $posts
		]);
	}
}