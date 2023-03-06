<?php

namespace App\Controllers;

use PDO;
class ConnectController extends PDO
{
	function connect()
	{
		$username = 'pofr8259_blogopen';
		$userpass = 'DelPFzMI2P1h';
		try {
			$bdd = new PDO('mysql:host=fportemer.fr;dbname=pofr8259_blogopen;charset=utf8', $username, $userpass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
			return $bdd;
		} catch (Exception $e) {

			die (' Erreur de connexion en base : ' . $e->getMessage());
		}
	}
}

