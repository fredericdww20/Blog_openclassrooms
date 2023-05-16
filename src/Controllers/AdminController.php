<?php

namespace App\Controllers;

class AdminController extends Controller
{
	// Rendu vers la page admin
	public function admin()
	{
		return $this->twig->render('admin/admin.html.twig');
	}

}