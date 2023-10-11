<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/Core/Request.php';


use App\Controllers\AdminController;
use App\Controllers\CommentController;
use App\Controllers\ConnectController;
use App\Controllers\MainController;
use App\Controllers\PostController;
use App\Controllers\RegisterController;
use App\Controllers\UserController;
use App\Core\Request;
use Steampixel\Route;

$request = new Request($_POST);

// Route Home
Route::add('/', function () {
    echo (new MainController())->index();
});
Route::add('/', function () {
    echo (new MainController())->swiftmailer();
}, 'post');

/// USERCONTROLLER //
Route::add('/profil', function () {
    echo (new UserController())->infouser();
});


/// ADMINCONTROLLER //
Route::add('/admin', function () {
    if (!isset($_SESSION['roles']) || $_SESSION['roles'] !== 'ROLE_ADMIN') {
        header('Location: /OpenClassrooms/login');
        if ($_SESSION['roles'] === 'ROLE_USER') {
            header('Location: /OpenClassrooms/');
        }
    }
    echo (new AdminController())->listvalidate();
});
Route::add('/admin', function () {
    if (!isset($_SESSION['roles']) || $_SESSION['roles'] !== 'ROLE_ADMIN') {
        header('Location: /OpenClassrooms/login');
        if ($_SESSION['roles'] === 'ROLE_USER') {
            header('Location: /OpenClassrooms/');
        }
    }
    echo (new AdminController())->listcomment();
});
Route::add('/admin/posts', function () {
    if (!isset($_SESSION['roles']) || $_SESSION['roles'] !== 'ROLE_ADMIN') {
        header('Location: /OpenClassrooms/login');
        if ($_SESSION['roles'] === 'ROLE_USER') {
            header('Location: /OpenClassrooms/');
        }
    }
    echo (new AdminController())->list();
});
Route::add('/admin/comment', function () {
    if (!isset($_SESSION['roles']) || $_SESSION['roles'] !== 'ROLE_ADMIN') {
        header('Location: /OpenClassrooms/login');
        if ($_SESSION['roles'] === 'ROLE_USER') {
            header('Location: /OpenClassrooms/');
        }
    }
    echo (new AdminController())->listcomment();
});
Route::add('/admin/com/([0-9]+)', function ($id) {
    if (!isset($_SESSION['roles']) || $_SESSION['roles'] !== 'ROLE_ADMIN') {
        header('Location: /OpenClassrooms/login');
        if ($_SESSION['roles'] === 'ROLE_USER') {
            header('Location: /OpenClassrooms/');
        }
    }
    echo (new AdminController())->updatecomments($id);
});
Route::add('/admin/com/([0-9]+)', function ($id) {
    if (!isset($_SESSION['roles']) || $_SESSION['roles'] !== 'ROLE_ADMIN') {
        header('Location: /OpenClassrooms/login');
        if ($_SESSION['roles'] === 'ROLE_USER') {
            header('Location: /OpenClassrooms/');
        }
    }
    echo (new AdminController())->updatecomments($id);
}, 'post');

Route::add('/admin/validate/([0-9]+)', function ($id) {
    if (!isset($_SESSION['roles']) || $_SESSION['roles'] !== 'ROLE_ADMIN') {
        header('Location: /OpenClassrooms/login');
        if ($_SESSION['roles'] === 'ROLE_USER') {
            header('Location: /OpenClassrooms/');
        }
    }
    echo (new AdminController())->update($id);
});
Route::add('/admin/validate/([0-9]+)', function ($id) {
    if (!isset($_SESSION['roles']) || $_SESSION['roles'] !== 'ROLE_ADMIN') {
        header('Location: /OpenClassrooms/login');
        if ($_SESSION['roles'] === 'ROLE_USER') {
            header('Location: /OpenClassrooms/');
        }
    }
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
    $request = new Request([
        'post' => $_POST,
    ]);
    echo (new CommentController())->addcomment($request);
}, ['GET', 'POST']);
Route::add('/deletecomment/([0-9]*)', function ($id) {
    echo (new CommentController())->deleteComment($id);
});

Route::add('/updatecomment/([0-9]*)', function ($id) {
    echo (new CommentController())->updateComment($id);
});
Route::add('/updatecomment/([0-9]*)', function ($id) {
    echo (new CommentController())->updateComment($id);
}, 'post');

// Run the router
Route::run('/OpenClassrooms/');