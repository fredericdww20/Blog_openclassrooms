<?php
namespace App\Controllers;

class MainController extends Controller


{
	public function index()
	{

		return $this->twig->render('main/index.html.twig',);
	}
}