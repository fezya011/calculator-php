<?php
namespace App\Views;

use Twig\Environment;

class FrontView
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

    public function home($articles, $page, $categories, $recentArticles): string
    {
        return $this->twig->render('home.twig', [
            'title' => $page['title'] ?? 'Главная страница',
            'content' => $page['content'] ?? '',
            'articles' => $articles,
            'categories' => $categories,
            'recent_articles' => $recentArticles,
            'all_articles_count' => count($articles)
        ]);
    }

    public function contact($page, $categories, $recentArticles): string
    {
        return $this->twig->render('contact.twig', [
            'title' => $page['title'] ?? 'Контакты',
            'content' => $page['content'] ?? '',
            'categories' => $categories,
            'recent_articles' => $recentArticles,

        ]);
    }

    public function about($page, $categories, $recentArticles): string
    {
        return $this->twig->render('about.twig', [
            'title' => $page['title'] ?? 'О нас',
            'content' => $page['content'] ?? '',
            'categories' => $categories,
            'recent_articles' => $recentArticles,

        ]);
    }

    public function more($page, $categories, $recentArticles): string
    {
        return $this->twig->render('more.twig', [
            'title' => $page['title'] ?? 'Дополнительно',
            'content' => $page['content'] ?? '',
            'categories' => $categories,
            'recent_articles' => $recentArticles,

        ]);
    }

    public function articles($articles, $categories, $currentCategory = null, $categoryInfo = null, $recentArticles = []): string
    {
        return $this->twig->render('articles.twig', [
            'title' => $currentCategory ?
                ($categoryInfo['icon'] ?? '📁') . ' ' . $currentCategory :
                '📚 Все статьи',
            'content' => '',
            'articles' => $articles,
            'categories' => $categories,
            'current_category' => $currentCategory,
            'category_info' => $categoryInfo,
            'recent_articles' => $recentArticles,

        ]);
    }

    public function article($article, $categories, $recentArticles): string
    {
        return $this->twig->render('article.twig', [
            'title' => $article['title'] ?? 'Статья',
            'article' => $article,
            'categories' => $categories,
            'recent_articles' => $recentArticles,

        ]);
    }

    public function categories($categories, $recentArticles): string
    {
        return $this->twig->render('categories.twig', [
            'title' => '📂 Категории статей',
            'categories' => $categories,
            'recent_articles' => $recentArticles,

        ]);
    }

    public function show404($categories, $recentArticles): string
    {
        return $this->twig->render('404.twig', [
            'title' => 'Страница не найдена',
            'categories' => $categories,
            'recent_articles' => $recentArticles,

        ]);
    }


}