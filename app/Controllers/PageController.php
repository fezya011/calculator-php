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
        $articles = $this->parser->getArticles(3);
        $page = $this->parser->getPage('home');

        $this->page_view->render('home', [
            'title' => $page['title'] ?? 'Главная страница',
            'content' => $page['content'] ?? '',
            'articles' => $articles // Добавляем статьи в данные
        ]);
    }

    public function contact()
    {
        $page = $this->parser->getPage('contact');
        $this->page_view->render('contact', [
            'title' => $page['title'] ?? 'Контакты',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function about()
    {
        $page = $this->parser->getPage('about');
        $this->page_view->render('about', [
            'title' => $page['title'] ?? 'О нас',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function articles() {
        $articles = $this->parser->getArticles();
        $page = $this->parser->getPage('articles');

        $this->page_view->render('articles', [
            'title' => $page['title'] ?? 'Статьи',
            'content' => $page['content'] ?? '',
            'articles' => $articles
        ]);
    }

    public function article($slug) {
        $article = $this->parser->getArticle($slug);

        if (!$article) {
            $this->notFound();
            return;
        }

        $this->page_view->render('article', [
            'title' => $article['title'] ?? 'Статья',
            'content' => $article['content'] ?? '',
            'article' => $article // Добавляем статью в данные
        ]);
    }

    public function notFound() {
        $this->page_view->show404();
    }
}