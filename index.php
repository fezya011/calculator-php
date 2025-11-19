<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/constants.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$router = require (ROOT_DIR . '/app/Views/bootstrap.php');

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router->get('/', 'App\Controllers\PageController::index');
$router->get('/about', 'App\Controllers\PageController::about');
$router->get('/contact', 'App\Controllers\PageController::contact');
$router->get('/calculator', 'App\Controllers\PageController::calculator');
$router->get('/more', 'App\Controllers\PageController::more');
$router->get('/articles', 'App\Controllers\PageController::articles');
$router->get('/categories', 'App\Controllers\PageController::showCategories');
$router->get('/article/{slug}', 'App\Controllers\PageController::showArticle');
$router->get('/page/{name}', 'App\Controllers\PageController::showPage');
$router->get('/{any:.*}', 'App\Controllers\PageController::notFound');

$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);