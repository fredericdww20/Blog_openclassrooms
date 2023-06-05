<?php

namespace App\Controllers;

use App\Models\CommentManager;

class AdminController extends Controller
{
	// Rendu vers la page admin
	public function admin()
	{
		return $this->twig->render('admin/admin.html.twig');
	}

}