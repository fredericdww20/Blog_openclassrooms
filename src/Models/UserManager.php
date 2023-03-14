<?php

namespace App\Models;

class UserManager
{
	private \PDO $pdo;

	public function __construct()
	{
		$this->pdo = new \PDO('________');
	}

	public function create()
	{
		$sql = 'INSERT ...';

		$this->pdo->prepare($sql);

		$this->pdo->exec([
			''
		]);
	}

	public function fetchAll()
	{
		$sql = 'SELECT ...';
		$this->pdo->prepare($sql);
		$posts = $this->pdo->exec();

		return $posts;
	}

	public function delete()
	{

	}

	public function update()
	{

	}

	public function fetch(int $id)
	{

	}

	public function authentication(string $username, string $password)
	{

	}
}