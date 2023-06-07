<?php

namespace App\Models;

class Post
{
	private ?int $id = 0;
	private string $title;
	private string $description;
	private string $chapo;
	private bool $sta;
	private string $updated_at;
	private string $created_at;

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

	public function getSta(): bool
	{
		return $this->sta;
	}

	public function setSta(bool $sta): void
	{
		$this->sta = $sta;
	}

	public function getUpdated_at(): string
	{
		return $this->updated_at;
	}

	public function setUpdated_at(string $updated_at): void
	{
		$this->updated_at = $updated_at;
	}
	public function getCreatedAt(): string
	{
		return $this->created_at;
	}
	public function setCreated_at(string $created_at): void
	{
		$this->created_at = $created_at;
	}

}