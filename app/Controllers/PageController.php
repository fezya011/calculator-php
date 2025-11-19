<?php
namespace App\Controllers;

use App\Core\ContentParser;
use App\Views\PageView;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PageController
{
    private ContentParser $parser;
    private PageView $page_view;

    public function __construct(ContentParser $parser, PageView $page_view)
    {
        $this->parser = $parser;
        $this->page_view = $page_view;
    }

    public function responseWrapper(string $str): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write($str);
        return $response;
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return $this->home($request);
    }

    public function home(ServerRequestInterface $request): ResponseInterface
    {
        $articles = $this->parser->getArticles(3);
        $page = $this->parser->getPage('home');

        $html = $this->page_view->home($articles, $page);
        return $this->responseWrapper($html);
    }

    public function contact(ServerRequestInterface $request): ResponseInterface
    {
        $page = $this->parser->getPage('contact');
        $html = $this->page_view->contact($page);
        return $this->responseWrapper($html);
    }

    public function about(ServerRequestInterface $request): ResponseInterface
    {
        $page = $this->parser->getPage('about');
        $html = $this->page_view->about($page);
        return $this->responseWrapper($html);
    }

    public function calculator(ServerRequestInterface $request): ResponseInterface
    {
        $page = $this->parser->getPage('calculator');
        $html = $this->page_view->calculator($page);
        return $this->responseWrapper($html);
    }

    public function more(ServerRequestInterface $request): ResponseInterface
    {
        $page = $this->parser->getPage('more');
        $html = $this->page_view->more($page);
        return $this->responseWrapper($html);
    }

    public function articles(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $category = $queryParams['category'] ?? null;

        if ($category) {
            $articles = $this->parser->getArticlesByCategory($category);
            $categoryInfo = $this->parser->getCategoryInfo($category);
        } else {
            $articles = $this->parser->getArticles();
            $categoryInfo = null;
        }

        $categories = $this->parser->getCategories();

        $html = $this->page_view->articles($articles, $categories, $category, $categoryInfo);
        return $this->responseWrapper($html);
    }

    public function showArticle(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $slug = $args['slug'] ?? '';
        $article = $this->parser->getArticle($slug);

        if (!$article) {
            return $this->notFound($request);
        }

        $html = $this->page_view->article($article);
        return $this->responseWrapper($html);
    }

    public function showCategories(ServerRequestInterface $request): ResponseInterface
    {
        $categories = $this->parser->getCategories();
        $html = $this->page_view->categories($categories);
        return $this->responseWrapper($html);
    }

    public function showPage(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $pageName = $args['name'] ?? '';
        $page = $this->parser->getPage($pageName);

        if (!$page) {
            return $this->notFound($request);
        }

        // Используем общий метод render для статических страниц
        $html = $this->page_view->render($pageName, [
            'title' => $page['title'] ?? ucfirst($pageName),
            'content' => $page['content'] ?? ''
        ]);
        return $this->responseWrapper($html);
    }

    public function notFound(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->page_view->show404();
        $response = $this->responseWrapper($html);
        return $response->withStatus(404);
    }
}