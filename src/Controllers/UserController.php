<?php

namespace App\Controllers;

use App\Models\UserManager;

class UserController extends Controller
{
	public function infouser()
	{
		$userManager = new Usermanager();
		$user = $userManager->fetchuser();
		return $this->twig->render('profil/profil.html.twig', [
			'user' => $user,
		]);
	}
}