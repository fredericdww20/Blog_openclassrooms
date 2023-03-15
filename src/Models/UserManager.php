<?php

namespace App\Models;

class UserManager
{
	private \PDO $pdo;

	public function __construct()
	{
		try {
			$this->pdo = new \PDO('mysql:host=fportemer.fr;dbname=pofr8259_blogopen;charset=utf8', 'pofr8259_blogopen', 'DelPFzMI2P1h');
		}
		catch (\Exception $e)
		{
			die('Erreur de connexion : ' . $e->getMessage());
		}
	}

	public function create(string $name, string $firstname, string $email, string $password)
	{
		$sql = 'INSERT INTO user(name, firstname, email, password) VALUES (:name, :firstname, :email, :password)';

		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'name' => $name,
			'firstname' => $firstname,
			'email' => $email,
			'password' => password_hash($password, PASSWORD_BCRYPT),
		]);
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

	public function authentication(string $name, string $password)
	{

	}
}