<?php

namespace App\Manager;

use App\Core\Database;
use App\Models\Comment;
use PDO;

class CommentManager

{
    private PDO $pdo;

    // Connexion à la base de données
    public function __construct() {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function commentate(string $title, string $commentary, int $postId, int $userId): void
    {
        $sql = 'INSERT INTO comment (title, commentary, sta, id_post, id_user) VALUES (:title, :commentary, :sta, :postId, :userId)';
        $sta = 0;

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':commentary', $commentary);
        $statement->bindParam(':sta', $sta);
        $statement->bindParam(':postId', $postId);
        $statement->bindParam(':userId', $userId);

        $statement->execute();
    }

    public function fetch(int $id)
    {
        $sql = 'SELECT p.id as post_id, c.*, u.lastname, u.firstname
    FROM comment AS c 
    JOIN post AS p ON c.id_post = p.id 
    JOIN user AS u ON c.id_user = u.id 
    WHERE p.id = :id AND c.sta = 1';

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            ':id' => $id
        ]);

        return $statement->fetchAll(PDO::FETCH_CLASS, Comment::class);

    }
    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM comment WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $id
        ]);

        return $statement->fetchObject(Comment::class);
    }

    public function fetchcomment(int $id)
    {
        $sql = 'SELECT * FROM comment WHERE id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $id
        ]);

        return $statement->fetchObject(Comment::class);
    }

    public function update(int $id, string $title, string $commentary)
    {
        $sql = 'UPDATE comment SET title = :title, commentary = :commentary, sta = 0 WHERE id = :id';

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            'id' => $id,
            'title' => $title,
            'commentary' => $commentary
        ]);

        return $this->fetch($id);
    }



}