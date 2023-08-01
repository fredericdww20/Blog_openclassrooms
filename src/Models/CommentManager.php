<?php

namespace App\Models;

use PDO;
use PDOException;

require_once __DIR__ . '/config.php';
class CommentManager

{
    private PDO $pdo;

    public function __construct() {

        $pdoOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
            $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $pdoOptions);
        } catch (PDOException $e) {
            echo 'Connection error: ' . $e->getMessage();
            return;
        }

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
        $sql = 'SELECT c.*, u.lastname, u.firstname
            FROM comment AS c 
            JOIN post AS p ON c.id_post = p.id 
            JOIN user AS u ON p.id_user = u.id 
            WHERE p.id = :id AND c.sta = 1';

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            ':id' => $id
        ]);

        return $statement->fetchAll(PDO::FETCH_CLASS, Comment::class);
    }

}