<?php

namespace App\Controllers;

use App\Models\UserManager;
use PDO;
class ConnectController extends Controller
{
	public function connect()
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		$userManager = new UserManager();

		$user = $userManager->authentication($username, $password);

		if ($user) {

			// Je mets les données en session

		} else {

			// J'affiche un message d'erreur
			// Je redirige vers la home
		}

		return $this->twig->render('login/login.html.twig');
	}
}

