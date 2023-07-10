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

	// Permet la mise à jour d'un post pour le publier.
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

	// Permet la mise à jour d'un commentaire pour le publier.
	public function updatecomment(int $id, bool $sta): ?Comment
	{
		$sql = 'UPDATE comment SET sta = :sta WHERE id = :id';
		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'id' => $id,
			'sta' => $sta,
		]);

		return $this->fetchcomments($id);
	}

	// Récupère les commentaires à valider.
	public function fetchcomment()
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

	// Récupère les posts à valider.
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

	// Récupère les 4 dernier posts valider.
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

	// Récupère les posts via l'id
	public function fetch(int $id)
	{
		$sql = 'SELECT * FROM post WHERE id = :id';

		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'id' => $id
		]);

		return $statement->fetchObject(Post::class);
	}

	// Récupére les commentaire via l'id
	public function fetchcomments(int $id)
	{
		$sql = 'SELECT * FROM comment WHERE id = :id';

		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'id' => $id
		]);

		return $statement->fetchObject(Comment::class);
	}

}