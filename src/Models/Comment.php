<?php

namespace App\Models;

class Comment
{
	private ?int $id = 0;
	private string $title;
	private string $commentary;
	private string $id_post;
	private string $id_user;

	public function setId(int $id): void
	{
		$this->id = $id;
	}
	public function getId(): int
	{
		return $this->id;
	}
	public  function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function  setCommentary(string $commentary): void
	{
		$this->commentary = $commentary;
	}

	public function getCommentary(): string
	{
		return $this->commentary;
	}
	public function  setIdPost(string $id_post): void
	{
		$this->id_post = $id_post;
	}
	public function getIdPost(): string
	{
		return $this->id_post;
	}

	public function  setIdUser(string $id_user): void
	{
		$this->id_user = $id_user;
	}

	public function getIdUser(): string
	{
		return $this->id_user;
	}



}