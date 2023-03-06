<?php

namespace App\Controllers;

class RegisterController {

	public function register()
	{
		header('Location: ./src/Views/inscription.php');
		exit;

	}

}