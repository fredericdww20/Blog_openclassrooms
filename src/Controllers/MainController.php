<?php
namespace App\Controllers;


class MainController extends Controller
{
	// Rendu vers la page principale
	public function index()
	{
		return $this->twig->render('main/index.html.twig');
	}
}