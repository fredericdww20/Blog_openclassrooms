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

		if (isset($_POST['email']) && isset($_POST['password'])) {
			$email = $_POST['email'];
			$password = $_POST['password'];

			try {

				if ($userManager->checkEmailExists($email)) {
					$user = $userManager->authentication($email, $password);

					if ($user) {
						$_SESSION['LOGGED_USER'] = $user->getEmail();
						$_SESSION['ROLE_USER'] = $user->getRoles();
						$_SESSION['USER_ID'] = $user->getId();
						header('Location: /OpenClassrooms/');
						exit;
					} else {
						$message = 'Identifiants de connexion incorrects';
					}
				} else {
					$message = 'Utilisateur non trouvé';
				}
			} catch (Exception $e) {
				$message = 'Une erreur s\'est produite lors de l\'authentification';

			}
		}

		return $this->twig->render('login/login.html.twig', [
			'message' => $message
		]);
	}





	public function logout()
	{
		session_start();
		session_destroy();
		header('Location: /OpenClassrooms/');
		exit;
	}
}

