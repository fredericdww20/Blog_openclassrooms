<?php

namespace App\Models;

use PDO;

class PostManager
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