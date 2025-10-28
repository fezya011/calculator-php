<?php

namespace App\Views;

class PageView
{
    public function render($template, $data = [])
    {
        extract($data);

        // Подключаем header
        include ROOT_DIR . '/content/templates/header.php';

        // Подключаем sidebar
        include ROOT_DIR . '/content/templates/sidebar.php';

        // Рендерим основной контент
        if ($template === 'home' || $template === 'more' || $template === 'calculator' || $template === 'about' || $template === 'contact') {
            // Для статических страниц
            include ROOT_DIR . "/content/pages/{$template}.php";
        } elseif ($template === 'articles') {
            // Для страницы со списком статей
            $this->renderArticlesPage($articles ?? []);
        } elseif ($template === 'article') {
            // Для отдельной статьи
            $this->renderArticlePage($article ?? []);
        } elseif ($template === '404') {
            // Для страницы 404
            $this->render404Page();
        } else {
            // Для остальных случаев выводим контент напрямую
            echo $content ?? '';
        }

        // Подключаем footer
        include ROOT_DIR . '/content/templates/footer.php';
    }

    private function renderArticlesPage($articles)
    {
        ?>
        <div class="articles-page">
            <h1>📚 Все статьи</h1>

            <?php if (!empty($articles)): ?>
                <div class="articles-grid">
                    <?php foreach ($articles as $article): ?>
                        <div class="article-card">
                            <h2>
                                <a href="/article/<?= $article['meta']['slug'] ?? '' ?>">
                                    <?= htmlspecialchars($article['title'] ?? 'Без названия') ?>
                                </a>
                            </h2>

                            <div class="article-meta">
                                <span class="author">👤 <?= htmlspecialchars($article['meta']['author'] ?? 'Автор') ?></span>
                                <span class="date">📅 <?= $this->formatDate($article['meta']['date'] ?? '') ?></span>
                            </div>

                            <div class="article-excerpt">
                                <?= $article['excerpt'] ?? '' ?>
                            </div>

                            <a href="/article/<?= $article['meta']['slug'] ?? '' ?>" class="read-more">
                                Читать далее →
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-articles">
                    <p>😔 Статьи пока не добавлены</p>
                </div>
            <?php endif; ?>
        </div>

        <style>
            .articles-page {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .articles-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 20px;
                margin-top: 30px;
            }

            .article-card {
                background: white;
                padding: 25px;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                border-left: 4px solid #667eea;
                transition: transform 0.3s;
            }

            .article-card:hover {
                transform: translateY(-5px);
            }

            .article-card h2 {
                margin: 0 0 15px 0;
                font-size: 1.4rem;
            }

            .article-card h2 a {
                color: #333;
                text-decoration: none;
            }

            .article-card h2 a:hover {
                color: #667eea;
            }

            .article-meta {
                display: flex;
                gap: 15px;
                margin-bottom: 15px;
                font-size: 0.9rem;
                color: #666;
            }

            .article-excerpt {
                color: #555;
                line-height: 1.6;
                margin-bottom: 15px;
            }

            .read-more {
                display: inline-block;
                color: #667eea;
                text-decoration: none;
                font-weight: 500;
            }

            .read-more:hover {
                text-decoration: underline;
            }

            .no-articles {
                text-align: center;
                padding: 60px 20px;
                color: #666;
            }
        </style>
        <?php
    }

    private function renderArticlePage($article)
    {
        ?>
        <div class="article-detail">
            <nav class="breadcrumb">
                <a href="/articles">← Назад к статьям</a>
            </nav>

            <article>
                <header class="article-header">
                    <h1><?= htmlspecialchars($article['title'] ?? 'Статья') ?></h1>

                    <div class="article-meta">
                        <span class="author">👤 <?= htmlspecialchars($article['meta']['author'] ?? 'Автор') ?></span>
                        <span class="date">📅 <?= $this->formatDate($article['meta']['date'] ?? '') ?></span>
                    </div>
                </header>

                <div class="article-content">
                    <?= $article['content'] ?? '' ?>
                </div>

                <footer class="article-footer">
                    <a href="/articles" class="btn-back">← Все статьи</a>
                </footer>
            </article>
        </div>

        <style>
            .article-detail {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }

            .breadcrumb {
                margin-bottom: 30px;
            }

            .breadcrumb a {
                color: #667eea;
                text-decoration: none;
            }

            .breadcrumb a:hover {
                text-decoration: underline;
            }

            .article-header {
                margin-bottom: 30px;
                border-bottom: 2px solid #f0f0f0;
                padding-bottom: 20px;
            }

            .article-header h1 {
                font-size: 2.5rem;
                margin: 0 0 15px 0;
                color: #333;
                line-height: 1.3;
            }

            .article-meta {
                display: flex;
                gap: 20px;
                color: #666;
                font-size: 0.95rem;
            }

            .article-content {
                line-height: 1.8;
                font-size: 1.1rem;
                color: #444;
            }

            .article-content h2 {
                color: #333;
                margin-top: 2rem;
                margin-bottom: 1rem;
            }

            .article-content h3 {
                color: #555;
                margin-top: 1.5rem;
                margin-bottom: 0.5rem;
            }

            .article-content p {
                margin-bottom: 1.5rem;
            }

            .article-content ul, .article-content ol {
                margin-bottom: 1.5rem;
                padding-left: 2rem;
            }

            .article-content li {
                margin-bottom: 0.5rem;
            }

            .article-content blockquote {
                border-left: 4px solid #667eea;
                padding-left: 1rem;
                margin-left: 0;
                font-style: italic;
                color: #666;
                background: #f8f9fa;
                padding: 1rem;
                border-radius: 0 5px 5px 0;
            }

            .article-content pre {
                background: #2d3748;
                color: #e2e8f0;
                padding: 1rem;
                border-radius: 5px;
                overflow-x: auto;
                margin: 1.5rem 0;
            }

            .article-content code {
                background: #f8f9fa;
                padding: 0.2rem 0.4rem;
                border-radius: 3px;
                font-family: 'Courier New', monospace;
            }

            .article-footer {
                margin-top: 3rem;
                padding-top: 1.5rem;
                border-top: 1px solid #f0f0f0;
            }

            .btn-back {
                display: inline-block;
                background: #667eea;
                color: white;
                padding: 0.75rem 1.5rem;
                border-radius: 5px;
                text-decoration: none;
                transition: background 0.3s;
            }

            .btn-back:hover {
                background: #5a6fd8;
            }
        </style>
        <?php
    }

    private function render404Page()
    {
        ?>
        <div class="error-page">
            <div class="error-content">
                <h1>😕 404 - Страница не найдена</h1>
                <p>Извините, но страница которую вы ищете не существует.</p>
                <div class="error-actions">
                    <a href="/" class="btn-primary">🏠 На главную</a>
                    <a href="/articles" class="btn-secondary">📚 К статьям</a>
                </div>
            </div>
        </div>

        <style>
            .error-page {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 60vh;
                text-align: center;
            }

            .error-content h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
                color: #333;
            }

            .error-content p {
                font-size: 1.2rem;
                color: #666;
                margin-bottom: 2rem;
            }

            .error-actions {
                display: flex;
                gap: 1rem;
                justify-content: center;
            }

            .btn-primary {
                display: inline-block;
                background: #667eea;
                color: white;
                padding: 1rem 2rem;
                border-radius: 5px;
                text-decoration: none;
                transition: background 0.3s;
            }

            .btn-primary:hover {
                background: #5a6fd8;
            }

            .btn-secondary {
                display: inline-block;
                background: #f8f9fa;
                color: #333;
                padding: 1rem 2rem;
                border-radius: 5px;
                text-decoration: none;
                border: 1px solid #ddd;
                transition: background 0.3s;
            }

            .btn-secondary:hover {
                background: #e9ecef;
            }
        </style>
        <?php
    }

    private function formatDate($date, $format = 'd.m.Y')
    {
        if (empty($date)) {
            return 'Дата не указана';
        }

        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return $date;
        }

        return date($format, $timestamp);
    }

    public function show404()
    {
        http_response_code(404);
        $this->render('404');
    }
}