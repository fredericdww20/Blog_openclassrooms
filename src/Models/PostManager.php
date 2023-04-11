<?php

namespace App\Models;

class PostManager
{

	private \PDO $pdo;

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

	public function creatpost(string $title, string $description, string $chapo)
	{
		$sql = 'INSERT INTO post (title, description, chapo) VALUES (:title, :description, :chapo)';

		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'title' => $title,
			'description' => $description,
			'chapo' => $chapo,
		]);
	}


	public function fetchAll()
	{
		$sql = 'SELECT * FROM post';

		$post = $this->pdo->prepare($sql);

		$post->execute();

		return $post->fetchAll();
	}

	public function fetch(int $id)
	{
		$sql = 'SELECT * FROM post WHERE id = :id';

		$post = $this->pdo->prepare($sql);

		$post->execute([
			'id' => $id,]);

		return $post->fetch();
	}

}