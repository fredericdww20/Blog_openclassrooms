<?php

namespace App\Models;

class Post
{
	private ?int $id = 0;
	private string $title;
	private string $description;
	private string $chapo;
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

	public function getDescription(): string
	{
		return $this->description;
	}

	public function setDescription(string $description): void
	{
		$this->description = $description;
	}

	public function getChapo(): string
	{
		return $this->chapo;
	}

	public function setChapo(string $chapo): void
	{
		$this->chapo = $chapo;
	}

}