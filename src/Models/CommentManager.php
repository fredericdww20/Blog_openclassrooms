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

	public function commentate(string $title, string $commentary, int $postId, int $userId): void
	{
		$sql = 'SELECT COUNT(*) FROM post WHERE id = :id';
		$statement = $this->pdo->prepare($sql);
		$statement->execute([':id' => $postId]);
		$count = $statement->fetchColumn();

		if ($count > 0) {

			$sql = 'INSERT INTO comment (title, commentary, sta, post_id, user_id) VALUES (:title, :commentary, :sta, :post_id, :user_id) ';

			$statement = $this->pdo->prepare($sql);

			$sta = 0;

			$statement->execute([
				':title' => $title,
				':commentary' => $commentary,
				':sta' => $sta,
				':post_id' => $postId,
				':user_id' => $userId
			]);
		} else {
			// Gérer le cas où l'ID du post n'existe pas
			throw new Exception("L'ID du post n'existe pas.");
		}
	}

	public function fetch(int $id)
	{
		$sql = 'SELECT c.* FROM comment AS c JOIN post AS p ON c.post_id = p.id WHERE p.id = :id';

		$statement = $this->pdo->prepare($sql);

		$statement->execute([
			':id' => $id
		]);

		return $statement->fetchObject(Comment::class);
	}


}