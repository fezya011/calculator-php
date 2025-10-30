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
            'articles' => $articles
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

    public function calculator()
    {
        $page = $this->parser->getPage('calculator');
        $this->page_view->render('calculator', [
            'title' => $page['title'] ?? 'Калькулятор',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function more()
    {
        $page = $this->parser->getPage('more');
        $this->page_view->render('more', [
            'title' => $page['title'] ?? 'Дополнительно',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function articles() {
        $category = $_GET['category'] ?? null;

        if ($category) {
            // Статьи по категории
            $articles = $this->parser->getArticlesByCategory($category);
            $categoryInfo = $this->parser->getCategoryInfo($category);
            $title = $categoryInfo['icon'] . " " . $category;
        } else {
            // Все статьи
            $articles = $this->parser->getArticles();
            $title = "📚 Все статьи";
        }

        $categories = $this->parser->getCategories();

        $this->page_view->render('articles', [
            'title' => $title,
            'content' => '',
            'articles' => $articles,
            'categories' => $categories,
            'current_category' => $category,
            'category_info' => $categoryInfo ?? null
        ]);
    }

    public function categories()
    {
        $categories = $this->parser->getCategories();

        $this->page_view->render('categories', [
            'title' => 'Категории статей',
            'content' => '',
            'categories' => $categories
        ]);
    }

    public function notFound() {
        $this->page_view->show404();
    }
}