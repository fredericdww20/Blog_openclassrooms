<?php
namespace App\Controllers;

class MainController extends Controller


{
	public function index()
	{
	 var_dump($_SESSION); die();
		return $this->twig->render('main/index.html.twig',);
	}
}