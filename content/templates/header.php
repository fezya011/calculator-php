<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Flat CMS' ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }
        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 2rem;
            margin-top: 2rem;
        }
        @media (max-width: 768px) {
            .main-container { grid-template-columns: 1fr; }
            .nav-links { gap: 1rem; }
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="nav-container">
        <a href="/" class="logo">📄 FlatCMS</a>
        <ul class="nav-links">
            <li><a href="/">Главная</a></li>
            <li><a href="/articles">Статьи</a></li>
            <li><a href="/categories">Категории</a></li> <!-- Новая ссылка -->
            <li><a href="/about">О нас</a></li>
            <li><a href="/contact">Контакты</a></li>
        </ul>
    </div>
</nav>

<div class="main-container">
    <main class="main-content">