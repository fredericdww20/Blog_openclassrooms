<?php

namespace App\Models;

class Comment
{
	private ?int $id = 0;
	private string $title;
	private string $commentary;

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



}