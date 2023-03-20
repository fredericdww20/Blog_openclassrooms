<?php

namespace App\Controllers;

use App\Models\UserManager;
class ConnectController extends Controller
{
	public function connect()
	{
		$userManager = new UserManager();

		if(isset($_POST['email']) && isset($_POST['password'])) {

			foreach ( $userManager as $user) {
				if (
					$user['email'] === $_POST['email'] &&
					$user['password'] === $_POST['password']
				) {
					$_SESSION['LOGGED_USER'] = $user['email'];
				}
			}
		}

		return $this->twig->render('login/login.html.twig');
	}
}

