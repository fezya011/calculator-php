<?php declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\RedirectResponse;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Начинаем сессию если еще не начата
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Отладочная информация
        error_log("=== AUTH MIDDLEWARE ===");
        error_log("Session status: " . session_status());
        error_log("Session ID: " . session_id());
        error_log("Username in session: " . ($_SESSION['username'] ?? 'NOT SET'));
        error_log("Request URI: " . $request->getUri()->getPath());

        if (!isset($_SESSION['username'])) {
            error_log("REDIRECTING TO LOGIN");
            return new RedirectResponse('/login');
        }

        error_log("USER AUTHENTICATED, PROCEEDING");
        return $handler->handle($request);
    }
}