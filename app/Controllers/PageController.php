<?php
namespace App\Controllers;

use App\Core\ContentParser;
use App\Views\PageView;

class PageController
{
    public $parser;
    public $page_view;

    public function __construct()
    {
        $this->parser = new ContentParser();
        $this->page_view = new PageView();
    }

    public function home()
    {
        $page = $this->parser->getPage('home');
        $this->page_view->render('home' , [
            'title' => $page['title'] ?? 'Главная страница',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function contact()
    {
        $page = $this->parser->getPage('contact');
        $this->page_view->render('contact' , [
            'title' => $page['title'] ?? 'Контакты',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function about()
    {
        $page = $this->parser->getPage('about');
        $this->page_view->render('about' , [
            'title' => $page['title'] ?? 'О нас',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function calculator()
    {
        $page = $this->parser->getPage('calculator');
        $this->page_view->render('calculator', [
            'title' => $page['title'] ?? 'Калькулятор',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function articles() {
        $page = $this->parser->getArticle('articles');
        $this->page_view->render('articles', [
            'title' => $page['title'] ?? 'Статьи',
            'content' => $page['content'] ?? ''
        ]);
    }




}