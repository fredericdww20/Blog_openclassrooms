<?php

namespace App\Controllers;

use App\Models\UserManager;
use App\Models\User;

class ConnectController extends Controller
{
	public function connect()
	{
		$userManager = new UserManager();
		$user = new User();
		$message = null;

		if(isset($_POST['email']) && isset($_POST['password'])) {

			$user = $userManager->authentication($_POST['email'], $_POST['password']);

			if ($user) {
				$_SESSION['LOGGED_USER'] = $user->getEmail();
				$_SESSION['ROLE_USER'] = $user->getRoles();
				header('Location: /OpenClassrooms/');
				exit();

			} else {
				$message = 'Utilisateur non trouvé';
			}

		}
		return $this->twig->render('login/login.html.twig', [
			'message' => $message
		]);
	}
}

