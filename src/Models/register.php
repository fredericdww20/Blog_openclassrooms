<?php

use App\Controllers\ConnectController;
class
{
	function addUser($name, $lastname, $email, $password) {
		$dbb= connect();
		$query = $dbb->prepare("INSERT INTO user (name, lastname, email, password) VALUES (:name, :lastname, :email, :password)");
		$query->bindParam(':prenom', $lastname);
		$query->bindParam('nom', $name);
		$query->bindParam('mail', $email);
		$query->bindParam('pass', $password);
		$query->execute();

	}
}