<?php

namespace App\Controllers;

use App\Models\UserManager;

class RegisterController extends Controller
{
	public function register()
	{
		if (!empty($_POST)) {
			$userManager = new UserManager();

			if($this->isValid($_POST)) {
				$userManager->create($_POST['name'], $_POST['firstname'], $_POST['email'], $_POST['password']);

				header('Location: login/login.html.twig');
				exit;

			} else {

			}
			
		}

		return $this->twig->render('register/register.html.twig');
	}

	public function isValid(array $data): bool
	{
		$name = htmlentities($data['name']);
		if(empty($name)) {
			return false;
		}

		return true;
	}
}