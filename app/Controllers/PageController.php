<?php
namespace App\Controllers;

use App\Core\ContentParser;

class PageController
{
    public $parser;

    public function __construct()
    {
        $this->parser = new ContentParser();
    }

    public function home()
    {
        $page = $this->parser->getPage('home');
        $this->render('home' , [
            'title' => $page['title'] ?? 'Главная страница',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function contact()
    {
        $page = $this->parser->getPage('contact');
        $this->render('contact' , [
            'title' => $page['title'] ?? 'Контакты',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function about()
    {
        $page = $this->parser->getPage('about');
        $this->render('about' , [
            'title' => $page['title'] ?? 'О нас',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function calculator()
    {
        $page = $this->parser->getPage('calculator');
        $this->render('calculator', [
            'title' => $page['title'] ?? 'Калькулятор',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function articles() {
        $page = $this->parser->getArticle('articles');
        $this->render('articles', [
            'title' => $page['title'] ?? 'Статьи',
            'content' => $page['content'] ?? ''
        ]);
    }

    private function render($template, $data = [])
    {
        extract($data);


        include ROOT_DIR .'/content/templates/header.php';
        include ROOT_DIR .'/content/templates/sidebar.php';


        if ($template === 'home' || $template === 'more' || $template === 'calculator' || $template === 'about') {

            include ROOT_DIR . "/content/pages/{$template}.php";
        } else {

            echo $content;
        }

        include ROOT_DIR . '/content/templates/footer.php';
    }

    public function show404()
    {
        include ROOT_DIR .'/content/templates/header.php';
        include ROOT_DIR .'/content/templates/sidebar.php';
        http_response_code(404);
        include ROOT_DIR . '/content/templates/404.php';
        include ROOT_DIR . '/content/templates/footer.php';
    }

}