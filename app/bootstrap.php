<?php
declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\FrontController;
use App\Core\ContentParser;
use App\Views\FrontView;
use App\Views\AdminView;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$container = new League\Container\Container();

$container->add(Environment::class, function () {
    $loader = new FilesystemLoader([
        VIEWS_PATH . '/front/pages',
        VIEWS_PATH . '/front/blocks',
        VIEWS_PATH . '/front',
        VIEWS_PATH . '/',
        VIEWS_PATH . '/back',
    ]);
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

$strategy = (new ApplicationStrategy)->setContainer($container);
$router = (new Router)->setStrategy($strategy);

return $router;