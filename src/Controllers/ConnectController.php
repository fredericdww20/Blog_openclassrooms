<?php

namespace App\Controllers;

use App\Models\UserManager;
use PDO;
class ConnectController extends Controller
{
	public function connect()
	{

		return $this->twig->render('login/login.html.twig');

	}
}

