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
    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
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


    public function fetch(int $id)
    {
        $sql = 'SELECT * FROM post WHERE id = :id';

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            'id' => $id
        ]);

        return $statement->fetchObject(Post::class);
    }


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



    public function fetchcomments(int $id)
    {
        $sql = 'SELECT * FROM comment WHERE id = :id';

        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            'id' => $id
        ]);

        return $statement->fetchObject(Comment::class);
    }



    public function fetchcomment()
    {
        $sql = '
    SELECT c.*, CONCAT(u.firstname, " ", u.lastname) as author_name
    FROM comment c
    JOIN user u ON c.id_user = u.id
    WHERE c.sta = 0
';

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $comments = [];
        while ($row = $statement->fetch()) {
            $comment = new Comment();
            $comment->setId($row['id']);
            $comment->setTitle($row['title']);
            $comment->setCommentary($row['commentary']);
            $comment->setCreatedAt($row['created_at']);
            $comment->setSta($row['id_user']);
            $row['author'] = $row['author_name'];
            $comments[] = $row;
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

    // Récupére les 5 posts les plus récents

    public function fetchAllData()
    {
        return [
            'posts' => $this->fetchAllPosts(),
            'comments' => $this->fetchAllComments()
        ];
    }

    private function fetchAllPosts()
    {
        $sql = 'SELECT * FROM post WHERE sta = 1 ORDER BY created_at DESC LIMIT 5';

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

    private function fetchAllComments()
    {
        $sql = '
    SELECT c.*, CONCAT(u.firstname, " ", u.lastname) as author_name
    FROM comment c
    JOIN user u ON c.id_user = u.id
    WHERE c.sta = 1
    ORDER BY c.created_at DESC
    LIMIT 5
';

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->setId($row['id']);
            $comment->setTitle($row['title']);
            $comment->setCommentary($row['commentary']);
            $comment->setCreatedAt($row['created_at']);
            $row['author'] = $row['author_name'];


            $comments[] = $row;
        }

        return $comments;
    }
}
