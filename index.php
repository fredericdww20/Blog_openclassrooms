<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once 'vendor/autoload.php';

use App\Controllers\RegisterController;
use App\Controllers\MainController;
use Steampixel\Route;

// Add the first route
Route::add('/', function () {
	echo (new MainController())->index();
});

Route::add('/inscription', function () {
	echo (new RegisterController())->register();
});

Route::add('/inscription', function () {
	echo (new RegisterController())->register();
}, 'post');

// Run the router
Route::run('/OpenClassrooms/');