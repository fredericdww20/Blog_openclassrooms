<?php

namespace App\Controllers;

use App\Models\UserManager;
use App\Models\User;

class ConnectController extends Controller
{
	public function connect()
	{
		$userManager = new UserManager();
		$message = null;

		if(isset($_POST['email']) && isset($_POST['password'])) {

			$user = $userManager->authentication($_POST['email'], $_POST['password']);

			if ($user) {
				$_SESSION['LOGGED_USER'] = $user->getEmail();
				$_SESSION['ROLE_USER'] = $user->getRoles();
				$_SESSION['USER_ID'] = $user->getId();
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

	public function logout() {

		session_destroy();

		header('Location: /OpenClassrooms/');

	}
}

