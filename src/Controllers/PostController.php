<?php

namespace App\Controllers;

class PostController {

	public function index()
	{
		return 'Hello world';

	}

	public function edit(int $id)
	{
		return 'Post : ' . $id;
	}


}