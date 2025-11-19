<?php
namespace App\Views;

use Twig\Environment;

class PageView
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render($template, $data = []): string
    {
        return $this->twig->render($template . '.twig', $data);
    }

    public function home($articles, $page): string
    {
        return $this->twig->render('home.twig', [
            'title' => $page['title'] ?? 'Главная страница',
            'content' => $page['content'] ?? '',
            'articles' => $articles
        ]);
    }

    public function contact($page): string
    {
        return $this->twig->render('contact.twig', [
            'title' => $page['title'] ?? 'Контакты',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function about($page): string
    {
        return $this->twig->render('about.twig', [
            'title' => $page['title'] ?? 'О нас',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function calculator($page): string
    {
        return $this->twig->render('calculator.twig', [
            'title' => $page['title'] ?? 'Калькулятор',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function more($page): string
    {
        return $this->twig->render('more.twig', [
            'title' => $page['title'] ?? 'Дополнительно',
            'content' => $page['content'] ?? ''
        ]);
    }

    public function articles($articles, $categories, $currentCategory = null, $categoryInfo = null): string
    {
        return $this->twig->render('articles.twig', [
            'title' => $currentCategory ?
                ($categoryInfo['icon'] ?? '📁') . ' ' . $currentCategory :
                '📚 Все статьи',
            'content' => '',
            'articles' => $articles,
            'categories' => $categories,
            'current_category' => $currentCategory,
            'category_info' => $categoryInfo
        ]);
    }

    public function article($article): string
    {
        return $this->twig->render('article.twig', [
            'title' => $article['title'] ?? 'Статья',
            'article' => $article
        ]);
    }

    public function categories($categories): string
    {
        return $this->twig->render('categories.twig', [
            'title' => '📂 Категории статей',
            'categories' => $categories
        ]);
    }

    public function show404(): string
    {
        return $this->twig->render('404.twig', [
            'title' => 'Страница не найдена'
        ]);
    }
}