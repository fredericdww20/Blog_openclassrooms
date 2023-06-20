<?php

namespace App\Models;


use PDO;

class UserManager
{
	private PDO $pdo;

	public function __construct()
	{
		try {
			$options = [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES => false,
			];

			$this->pdo = new PDO('mysql:host=fportemer.fr;dbname=pofr8259_blogopen;charset=utf8', 'pofr8259_blogopen', 'aW3GTb^~r@WA', $options);
		} catch (PDOException $e) {
			die('Erreur de connexion : ' . $e->getMessage());
		}
	}
	// Fonction enregistrement utilisateur en base de données
	public function create(string $lastname, string $firstname, string $email, string $password)
	{
		$sql = 'INSERT INTO user (lastname, firstname, email, password, roles) VALUES (:lastname, :firstname, :email, :password, :roles)';

		$statement = $this->pdo->prepare($sql);

		$roles = 'ROLE_USER';

		$statement->execute([
			'lastname' => $lastname,
			'firstname' => $firstname,
			'email' => $email,
			'roles' => $roles,
			'password' => password_hash($password, PASSWORD_DEFAULT),
		]);
	}

	public function authentication(string $email, string $password)
	{
		$sql = 'SELECT id, email, password, firstname, lastname, roles FROM user WHERE email = :email';

		$statement = $this->pdo->prepare($sql);
		$statement->execute([
			'email' => $email,
		]);

		$user = $statement->fetchObject(User::class);

		if ($user && password_verify($password, $user->getPassword())) {
			$_SESSION['email'] = $user->getEmail();
			$_SESSION['lastname'] = $user->getLastname();
			$_SESSION['firstname'] = $user->getFirstname();
			$_SESSION['roles'] = $user->getRoles();

			$_SESSION['USER_ID'] = $user->getId();
			return $user;
		}

		return null;
	}

	public function checkEmailExists(string $email): bool
	{
		$sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

		$statement = $this->pdo->prepare($sql);
		$statement->execute([
			'email' => $email,
		]);

		$count = $statement->fetchColumn();

		return ($count > 0);
	}


}