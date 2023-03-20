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
				$userManager->create($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password']);

				header('Location: /OpenClassrooms/login');
				exit;

			}
		}
		return $this->twig->render('register/register.html.twig');
	}

	public function isValid(array $data): bool
	{
		$firstname = htmlentities($data['firstname']);;
		$lastname = htmlentities($data['lastname']);
		$email = htmlentities($data['email']);
		$password = htmlentities($data['password']);
		if(empty($firstname) && empty($lastname) && empty($email) && empty($password)) {
			return false;
		}

		return true;
	}
}