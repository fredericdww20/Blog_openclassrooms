<?php

namespace App\Controllers;

use App\Models\UserManager;

class UserController extends Controller
{

	public function profil()
	{
		return $this->twig->render('profil/profil.html.twig');
	}

}