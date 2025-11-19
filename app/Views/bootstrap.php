<?php
declare(strict_types=1);

use App\Controllers\ArticleController;
use App\Controllers\PageController;
use App\Core\ContentParser;
use App\Views\PageView;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$container = new League\Container\Container();

// Twig Environment
// Twig Environment
$container->add(Environment::class, function () {
    $loader = new FilesystemLoader([
        VIEWS_PATH . '/templates',
        VIEWS_PATH . '/pages'
    ]);
    return new Environment($loader);
});

// ContentParser
$container->add(ContentParser::class);

// PageView
$container->add(PageView::class)
    ->addArguments([Environment::class]);

// Controllers
$container->add(PageController::class)
    ->addArguments([
        ContentParser::class,
        PageView::class
    ]);

$container->add(ArticleController::class)
    ->addArguments([
        ContentParser::class,
        PageView::class
    ]);

$strategy = (new ApplicationStrategy)->setContainer($container);
$router = (new Router)->setStrategy($strategy);

return $router;