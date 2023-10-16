<?php

namespace App\Models;

class Comment
{

    private ?int $id = 0;
    private string $title;
    private string $commentary;
    private string $created_at;
    private int $id_post;
    private int $id_user;
    private string $sta;




    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getSta(): string
    {
        return $this->sta;
    }

    public function setSta(string $sta): void
    {
        $this->sta = $sta;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getCommentary(): string
    {
        return $this->commentary;
    }

    public function setCommentary(string $commentary): void
    {
        $this->commentary = $commentary;
    }

    public function getIdPost(): int
    {
        return $this->id_post;
    }

    public function setIdPost(int $id_post): void
    {
        $this->id_post = $id_post;
    }

    public function getIdUser(): int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): void
    {
        $this->id_user = $id_user;
    }


}