<?php
// Включаем вывод ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/vendor/autoload.php';

// Определяем пути
define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);
define('CONTENT_PATH', ROOT_DIR . '/content');
define('VIEWS_PATH', ROOT_DIR . '/content/templates');
define('ASSETS_PATH', ROOT_DIR . '/assets');
define('UPLOAD_PATH', ROOT_DIR . '/assets/uploads');

// Автозагрузка классов
spl_autoload_register(function ($className) {
    $className = str_replace('App\\', '', $className);
    $file = ROOT_DIR . '/app/' . str_replace('\\', '/', $className) . '.php';

    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    return false;
});

use App\Controllers\PageController;
use App\Controllers\ArticleController;

$pageController = new PageController();
$articleController = new ArticleController();

// Получаем текущий путь
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);
$path = trim($path, '/');

// Убираем .php если есть
$path = str_replace('.php', '', $path);

// Маршрутизация
switch ($path) {
    case '':
        $pageController->home();
        break;
    case 'about':
        $pageController->about();
        break;
    case 'contact':
        $pageController->contact();
        break;
    case 'calculator':
        $pageController->calculator();
        break;
    case 'more':
        $pageController->more();
        break;
    case 'articles':
        $articleController->index();
        break;
    case 'categories':
        $articleController->categories();
        break;
    default:
        // Динамические маршруты для статей по категориям
        if (preg_match('#^articles/category/([a-zA-Z0-9\-_]+)$#', $path, $matches)) {
            $category = $matches[1];
            $articleController->index($category);
        }
        // Динамические маршруты для конкретных статей
        elseif (preg_match('#^article/([a-zA-Z0-9\-_]+)$#', $path, $matches)) {
            $slug = $matches[1];
            $articleController->show($slug);
        }
        // Статические страницы
        elseif (preg_match('#^page/(.+)$#', $path, $matches)) {
            $pageController->show($matches[1]);
        }
        else {
            $pageController->notFound();
        }
        break;
}