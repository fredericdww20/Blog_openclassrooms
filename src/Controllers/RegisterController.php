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
		$firstname = htmlspecialchars($data['firstname'], ENT_QUOTES, 'UTF-8');
		$lastname = htmlspecialchars($data['lastname'], ENT_QUOTES, 'UTF-8');
		$email = htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8');
		$password = htmlspecialchars($data['password'], ENT_QUOTES, 'UTF-8');

		if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
			return false;
		}

		return true;
	}

}