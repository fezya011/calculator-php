<?php
declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\AdminController;
use App\Controllers\FrontController;
use App\Middleware\AuthMiddleware;
use App\Core\ContentParser;
use App\Views\FrontView;
use App\Views\AdminView;
use App\Views\AuthView;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


$container = new League\Container\Container();

$container->add(AuthMiddleware::class);

$container->add(Environment::class, function () {
    $loader = new FilesystemLoader(array(
        VIEWS_PATH . '/front/pages',
        VIEWS_PATH . '/front/blocks',
        VIEWS_PATH . '/front',
        VIEWS_PATH . '/',
        VIEWS_PATH . '/back',
    ));
    return new Environment($loader);
});

$container->add(ContentParser::class);

$container->add(FrontView::class)
    ->addArguments([Environment::class]);
$container->add(FrontController::class)
    ->addArguments([
        ContentParser::class,
        FrontView::class
    ]);

$container->add(AdminView::class)
    ->addArguments([Environment::class]);
$container->add(AdminController::class)
    ->addArguments([
        ContentParser::class,
        AdminView::class
    ]);

$container->add(AuthView::class)
    ->addArguments([Environment::class]);
$container->add(AuthController::class)
    ->addArguments([
        ContentParser::class,
        AuthView::class
    ]);

$strategy = (new ApplicationStrategy)->setContainer($container);
$router = (new Router)->setStrategy($strategy);

return $router;