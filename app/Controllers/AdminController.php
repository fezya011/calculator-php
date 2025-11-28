<?php

namespace App\Controllers;

use App\Core\ContentParser;
use App\Views\AdminView;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminController
{
    private ContentParser $parser;
    private AdminView $admin_view;

    public function __construct(ContentParser $parser, AdminView $admin_view)
    {
        $this->parser = $parser;
        $this->admin_view = $admin_view;
    }

    public function responseWrapper(string $str): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write($str);
        return $response;
    }

    public function login(ServerRequestInterface $request): ResponseInterface
    {
        $page = $this->parser->getPage('login');
        $categories = $this->parser->getCategoriesWithCounts();
        $recentArticles = $this->parser->getArticles(3);

        $html = $this->admin_view->login($page, $categories, $recentArticles);
        return $this->responseWrapper($html);
    }

    public function dashboard(ServerRequestInterface $request): ResponseInterface
    {
        $articles = $this->parser->getArticles();
        $categories = $this->parser->getCategoriesWithCounts();
        $recentArticles = $this->parser->getArticles(3);

        $html = $this->admin_view->dashboard($articles, $categories, $recentArticles);
        return $this->responseWrapper($html);
    }

}