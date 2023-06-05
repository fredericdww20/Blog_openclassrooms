<?php

namespace App\Models;

class UserManager
{
	private \PDO $pdo;
	// Fonction de connexion à la base de données
	public function __construct()
	{
		try {
			$this->pdo = new \PDO('mysql:host=fportemer.fr;dbname=pofr8259_blogopen;charset=utf8', 'pofr8259_blogopen', 'aW3GTb^~r@WA');
		}
		catch (\Exception $e)
		{
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

	// Fonction verification utilisateur en base de données
	function authentication(string $email, string $password)
	{
		$sql = 'SELECT * FROM user WHERE email = :email';

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

			return $user;
		}

		return null;
	}

}