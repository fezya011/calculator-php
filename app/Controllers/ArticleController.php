<?php
namespace App\Controllers;

use App\Core\ContentParser;
use App\Views\PageView;

class ArticleController
{
    public $parser;
    public $page_view;

    public function __construct()
    {
        $this->parser = new ContentParser();
        $this->page_view = new PageView();
    }

    // Обновляем метод index для поддержки категорий через URL
    public function index($category = null)
    {
        // Если категория передана через URL, используем ее
        // Иначе берем из GET параметров для обратной совместимости
        $category = $category ?? ($_GET['category'] ?? null);

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

    public function show($slug)
    {
        // Получаем статью по slug
        $article = $this->parser->getArticle($slug);

        if (!$article) {
            // Если статья не найдена, показываем 404
            $this->notFound();
            return;
        }

        $this->page_view->render('article', [
            'title' => $article['title'] ?? 'Статья',
            'content' => $article['content'] ?? '',
            'article' => $article
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

    public function notFound()
    {
        $this->page_view->show404();
    }
}