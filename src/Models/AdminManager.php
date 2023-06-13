<?php

namespace App\Models;

use PDO;

class AdminManager
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

	public function updatecomment(int $id, bool $sta): ?Post
	{
		$sql = 'UPDATE comment SET sta = :sta WHERE id = :id';
		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'id' => $id,
			'sta' => $sta,
		]);

		return $this->fetch($id);
	}


	public function update(int $id, bool $sta): ?Post
	{
		$sql = 'UPDATE post SET sta = :sta WHERE id = :id';
		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'id' => $id,
			'sta' => $sta,
		]);

		return $this->fetch($id);
	}

	public function fetchComment()
	{
		$sql = 'SELECT * FROM comment WHERE sta = 0';

		$statement = $this->pdo->prepare($sql);

		$statement->execute();

		$comments = [];
		while ($row = $statement->fetch()) {
			$comment = new Comment();
			$comment->setId($row['id']);
			$comment->setTitle($row['title']);
			$comment->setCommentary($row['commentary']);
			$comment->setCreatedAt($row['created_at']);
			$comments[] = $comment;
		}

		return $comments;
	}

	public function fetchvalidate()
	{
		$sql = 'SELECT * FROM post WHERE sta = 0';

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

	public function fetchAll()
	{
		$sql = 'SELECT * FROM post WHERE sta = 1 ORDER BY created_at DESC LIMIT 4';

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

}