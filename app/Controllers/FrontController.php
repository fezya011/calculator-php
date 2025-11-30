<?php
namespace App\Controllers;

use App\Core\ContentParser;
use App\Views\FrontView;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FrontController
{
    private ContentParser $parser;
    private FrontView $front_view;

    public function __construct(ContentParser $parser, FrontView $front_view)
    {
        $this->parser = $parser;
        $this->front_view = $front_view;
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
        $categories = $this->parser->getCategoriesWithCounts();
        $recentArticles = $this->parser->getArticles(3);

        $html = $this->front_view->home($articles, $page, $categories, $recentArticles);
        return $this->responseWrapper($html);
    }

    public function contact(ServerRequestInterface $request): ResponseInterface
    {
        $page = $this->parser->getPage('contact');
        $categories = $this->parser->getCategoriesWithCounts();
        $recentArticles = $this->parser->getArticles(3);

        $html = $this->front_view->contact($page, $categories, $recentArticles);
        return $this->responseWrapper($html);
    }

    public function about(ServerRequestInterface $request): ResponseInterface
    {
        $page = $this->parser->getPage('about');
        $categories = $this->parser->getCategoriesWithCounts();
        $recentArticles = $this->parser->getArticles(3);

        $html = $this->front_view->about($page, $categories, $recentArticles);
        return $this->responseWrapper($html);
    }


    public function more(ServerRequestInterface $request): ResponseInterface
    {
        $page = $this->parser->getPage('more');
        $categories = $this->parser->getCategoriesWithCounts();
        $recentArticles = $this->parser->getArticles(3);

        $html = $this->front_view->more($page, $categories, $recentArticles);
        return $this->responseWrapper($html);
    }

    public function articles(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $category = $queryParams['category'] ?? null;

        if ($category) {
            $articles = $this->parser->getArticlesByCategory($category);

        } else {
            $articles = $this->parser->getArticles();
            $categoryInfo = null;
        }

        $categories = $this->parser->getCategoriesWithCounts();
        $recentArticles = $this->parser->getArticles(3);

        $html = $this->front_view->articles($articles, $categories, $category, $categoryInfo, $recentArticles);
        return $this->responseWrapper($html);
    }

    public function showArticle(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $slug = $args['slug'] ?? '';
        $article = $this->parser->getArticle($slug);

        if (!$article) {
            return $this->notFound($request);
        }

        $categories = $this->parser->getCategoriesWithCounts();
        $recentArticles = $this->parser->getArticles(3);

        $html = $this->front_view->article($article, $categories, $recentArticles);
        return $this->responseWrapper($html);
    }

    public function showCategories(ServerRequestInterface $request): ResponseInterface
    {
        $categories = $this->parser->getCategoriesWithCounts();
        $recentArticles = $this->parser->getArticles(3);

        $html = $this->front_view->categories($categories, $recentArticles);
        return $this->responseWrapper($html);
    }

    public function showPage(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $pageName = $args['name'] ?? '';
        $page = $this->parser->getPage($pageName);

        if (!$page) {
            return $this->notFound($request);
        }

        $categories = $this->parser->getCategoriesWithCounts();
        $recentArticles = $this->parser->getArticles(3);

        $html = $this->front_view->render($pageName, [
            'title' => $page['title'] ?? ucfirst($pageName),
            'content' => $page['content'] ?? '',
            'categories' => $categories,
            'recent_articles' => $recentArticles,
            'all_articles_count' => count($this->parser->getArticles())
        ]);
        return $this->responseWrapper($html);
    }

    public function notFound(ServerRequestInterface $request): ResponseInterface
    {
        $categories = $this->parser->getCategoriesWithCounts();
        $recentArticles = $this->parser->getArticles(3);

        $html = $this->front_view->show404($categories, $recentArticles);
        $response = $this->responseWrapper($html);
        return $response->withStatus(404);
    }
}