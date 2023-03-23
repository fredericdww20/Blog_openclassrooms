<?php

namespace App\Controllers;

use App\Models\UserManager;
class ConnectController extends Controller
{
	public function connect()
	{
		$userManager = new UserManager();
		$message = null;

		if(isset($_POST['email']) && isset($_POST['password'])) {

			$user = $userManager->authentication($_POST['email'], $_POST['password']);

			if ($user) {
				$_SESSION['LOGGED_USER'] = $user['email'];
				header('Location: /OpenClassrooms/');
				exit();

			} else {
				$message = 'User not found';
			}

		}
		return $this->twig->render('login/login.html.twig', [
			'message' => $message
		]);
	}
}

