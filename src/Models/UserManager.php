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
	public function authentication(string $email, string $password)
	{
		$sql = 'SELECT * FROM user WHERE email = :email';

		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'email' => $email,
		]);

		$user = $statement->fetch();

		if ($user && password_verify($password, $user['password'])) {

			$_SESSION['email'] = $user['email'];
			$_SESSION['lastname'] = $user['lastname'];
			$_SESSION['firstname'] = $user['firstname'];
			$_SESSION['roles'] = $user['roles'];

			return $user;
		}

		return null;
	}

	// Fonction pour récupérer les informations utilisateur.
	public function infosuser(string $email)
	{
		$sql = 'SELECT * FROM user WHERE email = :email';

		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'email' => $email
		]);

		$users = $statement->fetch();

		return $users;
	}



	public function fetchAll()
	{
		$sql = 'SELECT ...';
		$this->pdo->prepare($sql);
		$posts = $this->pdo->exec();

		return $posts;
	}

	public function delete(int $id)
	{
		$sql = 'DELETE FROM user WHERE id = :id';

		$statement = $this->pdo->prepare($sql);
		
		$this->pdo->exec([
			'id' => $id,
		]);
	}

	public function update()
	{
		$sql = 'UPDATE user SET name = :name, firstname = :firstname, email = :email  WHERE id = :id ';
		
		$this->pdo->prepare($sql);


	}

	public function fetch(int $id)
	{

	}

}