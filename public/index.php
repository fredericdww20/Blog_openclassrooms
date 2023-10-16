<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/Core/Request.php';
require '../src/Core/Router.php';
require '../src/Core/Response.php';


use App\Controllers\AdminController;
use App\Controllers\CommentController;
use App\Controllers\ConnectController;
use App\Controllers\MainController;
use App\Controllers\PostController;
use App\Controllers\RegisterController;
use App\Controllers\UserController;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
//use Steampixel\Route;


$router = new Router();

function isAdmin() {
    return isset($_SESSION['roles']) && $_SESSION['roles'] === 'ROLE_ADMIN';
}

// Fonction pour rediriger en fonction du rôle
function redirectToAppropriatePage() {
    if (isset($_SESSION['roles']) && $_SESSION['roles'] === 'ROLE_USER') {
        return new \App\Core\Response("", 302, [ "Location" => "/OpenClassrooms/" ]);
    }
    return new \App\Core\Response("", 302, [ "Location" => "/OpenClassrooms/login" ]);
}

$router->addRoute('GET', '~^/$~', function() {
    require_once '.././src/Controllers/MainController.php';
    $controller = new MainController();
    return new Response($controller->index());
});
$router->addRoute('POST', '~^/$~', function() {
    require_once '.././src/Controllers/MainController.php';
    $controller = new MainController();
    return new \App\Core\Response($controller->swiftmailer());
});
//Route::add('/', function () {
//    echo (new MainController())->swiftmailer();
//}, 'post');
//
///// USERCONTROLLER //
//Route::add('/profil', function () {
//    echo (new UserController())->infouser();
//});




/// ADMINCONTROLLER //
// Fonction pour vérifier si l'utilisateur est un administrateur
$router->addRoute('GET', '~^/admin$~', function() {
    if (!isAdmin()) return redirectToAppropriatePage();
    $controller = new AdminController();
    return new \App\Core\Response($controller->listvalidate());
});

$router->addRoute('POST', '~^/admin$~', function() {
    if (!isAdmin()) return redirectToAppropriatePage();
    $controller = new AdminController();
    return new \App\Core\Response($controller->listcomment());
});

$router->addRoute('GET', '~^/admin/posts$~', function() {
    if (!isAdmin()) return redirectToAppropriatePage();
    $controller = new AdminController();
    return new \App\Core\Response($controller->list());
});

$router->addRoute('GET', '~^/admin/comment$~', function() {
    if (!isAdmin()) return redirectToAppropriatePage();
    $controller = new AdminController();
    return new \App\Core\Response($controller->listcomment());
});

$router->addRoute('GET', '~^/admin/com/([0-9]+)$~', function($id) {
    if (!isAdmin()) return redirectToAppropriatePage();
    $controller = new AdminController();
    return new \App\Core\Response($controller->updatecomments($id));
});

$router->addRoute('POST', '~^/admin/com/([0-9]+)$~', function($id) {
    if (!isAdmin()) return redirectToAppropriatePage();
    $controller = new AdminController();
    return new \App\Core\Response($controller->updatecomments($id));
});

$router->addRoute('GET', '~^/admin/validate/([0-9]+)$~', function($id) {
    if (!isAdmin()) return redirectToAppropriatePage();
    $controller = new AdminController();
    return new \App\Core\Response($controller->update($id));
});

$router->addRoute('POST', '~^/admin/validate/([0-9]+)$~', function($id) {
    if (!isAdmin()) return redirectToAppropriatePage();
    $controller = new AdminController();
    return new \App\Core\Response($controller->update($id));
});

///// CONNECTCONTROLLER //
$router->addRoute('GET', '~^/logout$~', function() {
    $controller = new ConnectController();
    return new \App\Core\Response($controller->logout());
});

$router->addRoute('GET', '~^/login$~', function() {
    $controller = new ConnectController();
    return new \App\Core\Response($controller->connect());
});

$router->addRoute('POST', '~^/login$~', function() {
    $controller = new ConnectController();
    return new \App\Core\Response($controller->connect());
});


/// REGISTERCONTROLLER //
$router->addRoute('GET', '~^/inscription$~', function() {
    $controller = new RegisterController();
    return new \App\Core\Response($controller->register());
});

$router->addRoute('POST', '~^/inscription$~', function() {
    $controller = new RegisterController();
    return new \App\Core\Response($controller->register());
});


///// POSTCONTROLLER //
// Route pour ajouter un post
$router->addRoute('GET', '~^/add$~', function() {
    $controller = new PostController();
    return new \App\Core\Response($controller->addpost());
});
$router->addRoute('POST', '~^/add$~', function() {
    $controller = new PostController();
    return new \App\Core\Response($controller->addpost());
});

// Route pour lister tous les posts
$router->addRoute('GET', '~^/posts$~', function() {
    $controller = new PostController();
    return new \App\Core\Response($controller->list());
});

// Route pour afficher un post spécifique
$router->addRoute('GET', '~^/post/([0-9]+)$~', function($id) {
    $controller = new PostController();
    return new \App\Core\Response($controller->show($id));
});

// Route pour supprimer un post
$router->addRoute('GET', '~^/delete/([0-9]+)$~', function($id) {
    $controller = new PostController();
    $controller->delete($id);
    // Redirection ou autre action après suppression
    return new \App\Core\Response('', 302, ['Location' => '/posts']);
});

// Route pour mettre à jour un post
$router->addRoute('GET', '~^/update/([0-9]+)$~', function($id) {
    $controller = new PostController();
    return new \App\Core\Response($controller->update($id));
});
$router->addRoute('POST', '~^/update/([0-9]+)$~', function($id) {
    $controller = new PostController();
    return new \App\Core\Response($controller->update($id));
});
//
//

/////// COMMENTCONTROLLER //
//Route::add('/comment', function () {
//    echo (new CommentController())->addcomment();
//});
//Route::add('/comment', function () {
//    $request = new Request([
//        'post' => $_POST,
//    ]);
//    echo (new CommentController())->addcomment($request);
//}, ['GET', 'POST']);
//Route::add('/deletecomment/([0-9]*)', function ($id) {
//    echo (new CommentController())->deleteComment($id);
//});
//
//Route::add('/updatecomment/([0-9]*)', function ($id) {
//    echo (new CommentController())->updateComment($id);
//});
//Route::add('/updatecomment/([0-9]*)', function ($id) {
//    echo (new CommentController())->updateComment($id);
//}, 'post');


$router->dispatch();