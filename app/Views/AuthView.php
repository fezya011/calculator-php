<?php

namespace App\Views;

use Twig\Environment;

class AuthView
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

    public function login($page): string
    {
        return $this->twig->render('login.twig', [
            'title' => $page['title'] ?? 'Вход в админку',
            'content' => $page['content'] ?? '',
        ]);
    }
}