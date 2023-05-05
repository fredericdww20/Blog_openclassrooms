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

		$statement = $this->pdo->prepare($sql);

		$statement->execute();

		$posts = [];
		while (($row = $statement->fetch())) {
			$post = new Post();
			$post->setId($row['id']);
			$post->setTitle($row['title']);
			$post->setChapo($row['chapo']);
			$post->setDescription('description');

			$posts[] = $post;
		}

		return $posts;
	}

	public function fetch(int $id)
	{
		$sql = 'SELECT * FROM post WHERE id = :id';

		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'id' => $id
		]);

		return $statement->fetchObject(Post::class);
	}

	public function delete(int $id)
	{
		$sql = 'DElETE FROM post WHERE id = :id';

		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'id' => $id
		]);

		return $statement->fetchObject(Post::class);
	}

}