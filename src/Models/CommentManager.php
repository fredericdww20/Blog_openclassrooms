<?php

namespace App\Models;

use Exception;
use PDO;

class CommentManager

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

	public function commentate(string $title, string $commentary): void
	{
		$sql = 'INSERT INTO comment (title, commentary, sta) VALUES (:title, :commentary, :sta) ';

		$statement = $this->pdo->prepare($sql);

		$sta = 0;

		$statement->execute([
			'title' => $title,
			'commentary' => $commentary,
			'sta' => $sta,
		]);
	}

	public function fetch(int $id)
	{
		$sql = 'SELECT * FROM comment WHERE id = :id';

		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			'id' => $id
		]);

		return $statement->fetchObject(Post::class);
	}


}