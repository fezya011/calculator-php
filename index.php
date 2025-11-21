<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/constants.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$router = require (ROOT_DIR . '/app/bootstrap.php');

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router->get('/', 'App\Controllers\FrontController::index');
$router->get('/about', 'App\Controllers\FrontController::about');
$router->get('/contact', 'App\Controllers\FrontController::contact');
$router->get('/more', 'App\Controllers\FrontController::more');
$router->get('/articles', 'App\Controllers\FrontController::articles');
$router->get('/categories', 'App\Controllers\FrontController::showCategories');
$router->get('/article/{slug}', 'App\Controllers\FrontController::showArticle');
$router->get('/page/{name}', 'App\Controllers\FrontController::showPage');
$router->get('/{any:.*}', 'App\Controllers\FrontController::notFound');

$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);