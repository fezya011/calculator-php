<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require_once "vendor/autoload.php";
include_once "config/constants.php";

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use App\Controllers\PageController;
use App\Views\PageView;

$pages = new PageController();
$views = new PageView();

$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

$path = trim($path, '/');

switch ($path) {
    case '':
        $pages->home();
        break;


    case 'about':
        $pages->about();
        break;

    case 'contact':
        $pages->contact();
        break;

    case 'articles':
        $pages->articles();
        break;

    default:
        $views->show404();
        break;

}