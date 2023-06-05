<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

use App\Controllers\AdminController;
use App\Controllers\RegisterController;
use App\Controllers\MainController;
use App\Controllers\ConnectController;
use App\Controllers\PostController;
use App\Controllers\CommentController;
use Steampixel\Route;

// Route Home
Route::add('/', function () {
	echo (new MainController())->index();
});
// Route Admin
Route::add('/admin', function () {
	echo (new AdminController())->admin();
});
// Route Session Logoot
Route::add('/logout', function () {
	echo (new ConnectController())->logout();
});

Route::add('/inscription', function () {
	echo (new RegisterController())->register();
});

Route::add('/inscription', function () {
	echo (new RegisterController())->register();
}, 'post');

// Route pour la connexion utilisateur
Route::add('/login', function () {
	echo (new ConnectController())->connect();
});

Route::add('/login', function () {
	echo (new ConnectController())->connect();
}, 'post');

// Route pour la publication d'un post
Route::add('/add', function () {
	echo (new PostController())->addpost();
});
Route::add('/add', function () {
	echo (new PostController())->addpost();
}, 'post');


Route::add('/comment', function () {
	echo (new CommentController())->addcommentay();
});

Route::add('/comment', function () {
	echo (new CommentController())->addcommentay();
}, 'post');

Route::add('/posts', function () {
	echo (new PostController())->list();
});

Route::add('/post/([0-9]*)', function ($id) {
	echo (new PostController())->show($id);
});

Route::add('/delete/([0-9]*)', function ($id) {
	 (new PostController())->delete($id);
	header('Location: /OpenClassrooms/posts');
	exit();
});

Route::add('/update/([0-9]*)', function ($id) {
	(new PostController())->update($id);
	header('Location: /OpenClassrooms/posts');
	exit();
});

// Run the router
Route::run('/OpenClassrooms/');