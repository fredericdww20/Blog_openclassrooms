<?php
namespace App\Controllers;

use App\Models\UserManager;

class RegisterController extends Controller
{
	const ERROR_EMAIL_EXISTS = 'Cet email est déjà utilisé.';
	const ERROR_MISSING_FIELDS = 'Veuillez remplir tous les champs.';

	public function register()
	{
		$userManager = new UserManager();
		$errorMessage = null;

		if (!empty($_POST)) {
			$firstname = htmlentities($_POST['firstname']);
			$lastname = htmlentities($_POST['lastname']);
			$email = htmlentities($_POST['email']);
			$password = $_POST['password'];

			if ($this->validateForm($_POST)) {
				if (!$userManager->checkEmailExists($email)) {

					$userId = $userManager->create($firstname, $lastname, $email, $password);

					header('Location: /OpenClassrooms/');
					exit;

				} else {
					$errorMessage = self::ERROR_EMAIL_EXISTS;
				}
			} else {
				$errorMessage = self::ERROR_MISSING_FIELDS;
			}
		}

		return $this->twig->render('register/register.html.twig', ['errorMessage' => $errorMessage]);
	}

	private function validateForm($formData): bool
	{
		return $this->validateFields($formData);
	}

	private function validateFields($formData): bool
	{
		$fields = ['firstname', 'lastname', 'email', 'password'];
		foreach ($fields as $field) {
			if (empty($formData[$field])) {
				return false;
			}
		}
		return true;
	}

}