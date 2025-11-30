<?php

namespace App\Controllers;

use App\Core\ContentParser;
use App\Views\AuthView;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthController
{
    private AuthView $auth_view;
    private ContentParser $parser;

    public function __construct(ContentParser $parser, AuthView $auth_view)
    {
        $this->parser = $parser;
        $this->auth_view = $auth_view;
    }

    public function responseWrapper(string $str): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write($str);
        return $response;
    }

    public function showLoginForm(ServerRequestInterface $request): ResponseInterface
    {
        if (isset($_SESSION['username'])) {
            return $this->redirect('/admin/dashboard');
        }
        $page = $this->parser->getPage('login');
        $html = $this->auth_view->login($page);
        return $this->responseWrapper($html);
    }

    public function redirect(string $uri):ResponseInterface
    {
        $response = new Response();
        return $response
            ->withStatus(302)
            ->withHeader('Location', $uri);
    }

    public function login(ServerRequestInterface $request) :ResponseInterface
    {
        $data = $request->getParsedBody();
        if ($data['username'] == 'admin' && $data['password'] == 'admin') {
            $_SESSION['username'] = $data['username'];
            return $this->redirect('/admin/dashboard');
        }
        return $this->redirect('/login');
    }

    public function logout(ServerRequestInterface $request) :ResponseInterface
    {
        unset($_SESSION['username']);
        return $this->redirect('/login');
    }
}