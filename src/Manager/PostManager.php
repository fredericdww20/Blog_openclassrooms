<?php

namespace App\Manager;

use App\Core\Database;
use App\Models\Post;
use PDO;

class PostManager
{
    private PDO $pdo;

    // Connexion à la base de données
    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function creatpost(string $title, string $description, string $chapo, int $userId)
    {
        $sql = 'INSERT INTO post (title, description, chapo, sta, id_user) VALUES (:title, :description, :chapo, :sta, :userId)';
        $statement = $this->pdo->prepare($sql);
        $sta = 0;

        $statement->execute([
            'title' => $title,
            'description' => $description,
            'chapo' => $chapo,
            'sta' => $sta,
            'userId' => $userId,
        ]);
    }

    public function fetchAll()
    {
        $sql = 'SELECT id, title, chapo, description, created_at, id_user FROM post WHERE sta = 1';

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
            $post->setIdUser($row['id_user']);

            $posts[] = $post;
        }

        return $posts;
    }

    public function fetch(int $id)
    {
        $sql = 'SELECT post.*, user.lastname, user.firstname FROM post 
            JOIN user ON post.id_user = user.id 
            WHERE post.id = :id';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);

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

    public function update(int $id, string $title, string $description, string $chapo): ?Post
    {
        $sql = 'UPDATE post SET title = :title, description = :description, updated_at = :updated_at, chapo = :chapo WHERE id = :id';

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'chapo' => $chapo,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->fetch($id);
    }
}
