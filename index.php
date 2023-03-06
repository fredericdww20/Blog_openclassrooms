<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once 'vendor/autoload.php';

use App\Controllers\PostController;
use App\Controllers\RegisterController;
use Steampixel\Route;

// Add the first route
Route::add('/post', function () {
	echo (new PostController())->index();
});

Route::add('/posts/([0-9]*)/edit', function (int $id) {
	echo (new PostController())->edit($id);
});

Route::add('/inscription', function () {
	echo (new RegisterController())->register();
});

// Run the router
Route::run('/OpenClassrooms/');