<?php

namespace App\Views;

use Twig\Environment;

class AdminView
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

    public function dashboard($articles, $categories, $recentArticles): string
    {
        return $this->twig->render('dashboard.twig', [
            'title' => 'Админ панель',
            'articles' => $articles,
            'categories' => $categories,
            'recent_articles' => $recentArticles,
            'all_articles_count' => count($articles)
        ]);
    }
}