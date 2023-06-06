<?php

namespace App\Models;

use Exception;
use PDO;

class PostManager
{

	private PDO $pdo;

	public function __construct()
	{
		try {
			$this->pdo = new PDO('mysql:host=fportemer.fr;dbname=pofr8259_blogopen;charset=utf8', 'pofr8259_blogopen', 'aW3GTb^~r@WA');
		} catch (Exception $e) {
			die('Erreur de connexion : ' . $e->getMessage());
		}
	}

	public function creatpost(string $title, string $description, string $chapo)
	{
		$sql = 'INSERT INTO post (title, description, chapo, sta) VALUES (:title, :description, :chapo, :sta)';

		$statement = $this->pdo->prepare($sql);

		$sta = 0;

		$statement->execute([
			'title' => $title,
			'description' => $description,
			'chapo' => $chapo,
			'sta' => $sta,
		]);
	}

	public function fetchAll()
	{
		$sql = 'SELECT * FROM post WHERE sta = 1';

		$statement = $this->pdo->prepare($sql);

		$statement->execute();

		$posts = [];
		while (($row = $statement->fetch())) {
			$post = new Post();
			$post->setId($row['id']);
			$post->setTitle($row['title']);
			$post->setChapo($row['chapo']);
			$post->setDescription($row['description']);
			$post->setCreated_at($row['created_at']);

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

	public function update(int $id, string $title, string $description, string $chapo)
	{
		$sql = 'UPDATE post SET title = :title, description = :description, chapo = :chapo WHERE id = :id';

		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'id' => $id,
			'title' => $title,
			'description' => $description,
			'chapo' => $chapo,
		]);

		return $statement->fetchObject(Post::class);
	}
}