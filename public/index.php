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
use App\Controllers\UserController;
use Steampixel\Route;


// Route Home
Route::add('/', function () {
	echo (new MainController())->index();
});
Route::add('/', function () {
	echo (new MainController())->swiftmailer();
}, 'post');

/// USERCONTROLLER //
Route::add('/profil', function () {
	echo (new UserController())->profil();
});

/// ADMINCONTROLLER //
Route::add('/admin', function () {
	echo (new AdminController())->listvalidate();
});
Route::add('/admin', function () {
	echo (new AdminController())->listcomment();
});
Route::add('/admin/posts', function () {
	echo (new AdminController())->list();
});
Route::add('/admin/comment', function () {
	echo (new AdminController())->listcomment();
});
Route::add('/admin/com/([0-9]*)', function ($id) {
	echo (new AdminController())->updatecomments($id);
});
Route::add('/admin/com/([0-9]*)', function ($id) {
	echo (new AdminController())->updatecomments($id);
}, 'post');
Route::add('/admin/validate/([0-9]*)', function ($id) {
	echo (new AdminController())->update($id);
});
Route::add('/admin/validate/([0-9]*)', function ($id) {
	echo (new AdminController())->update($id);
}, 'post');



/// CONNECTCONTROLLER //
Route::add('/logout', function () {
	echo (new ConnectController())->logout();
});
Route::add('/login', function () {
	echo (new ConnectController())->connect();
});
Route::add('/login', function () {
	echo (new ConnectController())->connect();
}, 'post');


/// REGISTERCONTROLLER //
Route::add('/inscription', function () {
	echo (new RegisterController())->register();
});

Route::add('/inscription', function () {
	echo (new RegisterController())->register();
}, 'post');



/// POSTCONTROLLER //
Route::add('/add', function () {
	echo (new PostController())->addpost();
});
Route::add('/add', function () {
	echo (new PostController())->addpost();
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
	echo (new PostController())->update($id);
});
Route::add('/update/([0-9]*)', function ($id) {
	echo (new PostController())->update($id);
}, 'post');



/// COMMENTCONTROLLER //
Route::add('/comment', function () {
	echo (new CommentController())->addcomment();
});
Route::add('/comment', function () {
	echo (new CommentController())->addcomment();
}, 'post');

// Run the router
Route::run('/OpenClassrooms/');