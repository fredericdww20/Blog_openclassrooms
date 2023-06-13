<?php
namespace App\Controllers;

use App\Models\UserManager;

class RegisterController extends Controller
{
	public function register()
	{
		if (!empty($_POST)) {
			$userManager = new UserManager();

			$firstname = htmlentities($_POST['firstname']);
			$lastname = htmlentities($_POST['lastname']);
			$email = htmlentities($_POST['email']);
			$password = htmlentities($_POST['password']);

			if ($this->isValid($_POST)) {
				if (!$userManager->checkEmailExists($email)) {
					$userManager->create($firstname, $lastname, $email, $password);

					header('Location: /OpenClassrooms/login');
					exit;
				} else {
					$errorMessage = 'Cet email est déjà utilisé.';
				}
			} else {
				$errorMessage = 'Veuillez remplir tous les champs.';
			}
		}

		return $this->twig->render('register/register.html.twig', [
			'errorMessage' => $errorMessage ?? null
		]);
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