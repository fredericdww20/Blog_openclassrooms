<?php

namespace App\Manager;

use App\Core\Database;
use App\Models\Comment;
use App\Models\Post;
use PDO;

class AdminManager
{
    private PDO $pdo;

    // Connexion à la base de données
    public function __construct() {
        $this->pdo = Database::getInstance()->getPdo();
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

    public function fetch(int $id)
    {
        $sql = 'SELECT * FROM post WHERE id = :id';

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            'id' => $id
        ]);

        return $statement->fetchObject(Post::class);
    }

    // Récupère les commentaires à valider.

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

    // Récupère les posts à valider.

    public function fetchcomments(int $id)
    {
        $sql = 'SELECT * FROM comment WHERE id = :id';

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            'id' => $id
        ]);

        return $statement->fetchObject(Comment::class);
    }

    // Récupère les 4 dernier posts valider.

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

    // Récupère les posts via l'id

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

    // Récupére les commentaire via l'id

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

}