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
        } elseif ($template === 'categories') {
            // Для страницы категорий
            $this->renderCategoriesPage($categories ?? []);
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
        $current_category = $_GET['category'] ?? '';
        $contentParser = new \App\Core\ContentParser();
        $categoryInfo = $contentParser->getCategoryInfo($current_category);
        ?>
        <div class="articles-page">
            <div class="page-header">
                <h1>
                    <?php if ($current_category): ?>
                        <?= htmlspecialchars($categoryInfo['icon'] ?? '📁') ?> <?= htmlspecialchars($current_category) ?>
                    <?php else: ?>
                        📚 Все статьи
                    <?php endif; ?>
                </h1>

                <?php if ($current_category && !empty($categoryInfo['description'])): ?>
                    <p class="category-description"><?= htmlspecialchars($categoryInfo['description']) ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($articles)): ?>
                <div class="articles-grid">
                    <?php foreach ($articles as $article): ?>
                        <div class="article-card">
                            <!-- Категория статьи -->
                            <?php if (isset($article['category_info'])): ?>
                                <div class="article-category" style="background: <?= htmlspecialchars($article['category_info']['color'] ?? '#667eea') ?>;">
                                    <?= htmlspecialchars($article['category_info']['icon'] ?? '📁') ?> <?= htmlspecialchars($article['meta']['category'] ?? 'Общее') ?>
                                </div>
                            <?php endif; ?>

                            <h2>
                                <a href="/article/<?= htmlspecialchars($article['slug'] ?? '') ?>">
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

                            <a href="/article/<?= htmlspecialchars($article['slug'] ?? '') ?>" class="read-more">
                                Читать далее →
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Статистика -->
                <div class="stats-container">
                    <p>Найдено <?= count($articles) ?> <?= $this->getArticleWord(count($articles)) ?>
                        <?php if ($current_category): ?>
                            в категории "<?= htmlspecialchars($current_category) ?>"
                        <?php endif; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="no-articles">
                    <p>
                        <?php if ($current_category): ?>
                            😔 В категории "<?= htmlspecialchars($current_category) ?>" нет статей
                        <?php else: ?>
                            😔 Статьи пока не добавлены
                        <?php endif; ?>
                    </p>
                    <a href="/articles" class="back-to-articles">📚 Все статьи</a>
                </div>
            <?php endif; ?>
        </div>

        <style>
            .articles-page {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .page-header {
                margin-bottom: 2rem;
            }

            .page-header h1 {
                margin: 0 0 0.5rem 0;
                font-size: 2rem;
                color: #333;
            }

            .category-description {
                margin: 0;
                color: #666;
                font-size: 1.1rem;
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
                transition: transform 0.3s;
                position: relative;
            }

            .article-card:hover {
                transform: translateY(-5px);
            }

            .article-category {
                position: absolute;
                top: -10px;
                left: 1rem;
                background: #667eea;
                color: white;
                padding: 0.3rem 0.8rem;
                border-radius: 15px;
                font-size: 0.75rem;
                font-weight: 500;
            }

            .article-card h2 {
                margin: 0.5rem 0 15px 0;
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
                background: #667eea;
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 5px;
                text-decoration: none;
                font-size: 0.9rem;
                transition: background 0.3s;
            }

            .read-more:hover {
                background: #5a6fd8;
            }

            .stats-container {
                text-align: center;
                margin-top: 2rem;
                padding: 1rem;
                background: #f8f9fa;
                border-radius: 8px;
            }

            .stats-container p {
                margin: 0;
                color: #666;
            }

            .no-articles {
                text-align: center;
                padding: 60px 20px;
                color: #666;
            }

            .no-articles p {
                margin-bottom: 1.5rem;
                font-size: 1.1rem;
            }

            .back-to-articles {
                display: inline-block;
                background: #667eea;
                color: white;
                padding: 0.75rem 1.5rem;
                border-radius: 6px;
                text-decoration: none;
                transition: background 0.3s;
            }

            .back-to-articles:hover {
                background: #5a6fd8;
            }

            @media (max-width: 768px) {
                .articles-grid {
                    grid-template-columns: 1fr;
                }

                .articles-page {
                    padding: 1rem;
                }

                .article-card {
                    padding: 1.5rem;
                }
            }
        </style>
        <?php
    }

    private function renderArticlePage($article)
    {
        $contentParser = new \App\Core\ContentParser();
        $categoryInfo = $contentParser->getCategoryInfo($article['meta']['category'] ?? '');
        ?>
        <div class="article-detail">
            <nav class="breadcrumb">
                <a href="/articles<?= isset($article['meta']['category']) && $article['meta']['category'] ? '?category=' . urlencode($article['meta']['category']) : '' ?>">
                    ← Назад к статьям
                </a>
            </nav>

            <article>
                <!-- Категория статьи -->
                <?php if (isset($article['meta']['category']) && $article['meta']['category']): ?>
                    <div class="article-category-badge" style="background: <?= htmlspecialchars($categoryInfo['color'] ?? '#667eea') ?>;">
                        <?= htmlspecialchars($categoryInfo['icon'] ?? '📁') ?> <?= htmlspecialchars($article['meta']['category']) ?>
                    </div>
                <?php endif; ?>

                <header class="article-header">
                    <h1><?= htmlspecialchars($article['title'] ?? 'Статья') ?></h1>

                    <div class="article-meta">
                        <span class="author">👤 <?= htmlspecialchars($article['meta']['author'] ?? 'Автор') ?></span>
                        <span class="date">📅 <?= $this->formatDate($article['meta']['date'] ?? '') ?></span>
                        <?php if (isset($article['meta']['category']) && $article['meta']['category']): ?>
                            <span class="category">
                                <?= htmlspecialchars($categoryInfo['icon'] ?? '📁') ?>
                                <a href="/articles?category=<?= urlencode($article['meta']['category']) ?>" style="color: #667eea; text-decoration: none;">
                                    <?= htmlspecialchars($article['meta']['category']) ?>
                                </a>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <div class="article-content">
                    <?= $article['content'] ?? 'Контент статьи отсутствует' ?>
                </div>

                <footer class="article-footer">
                    <a href="/articles<?= isset($article['meta']['category']) && $article['meta']['category'] ? '?category=' . urlencode($article['meta']['category']) : '' ?>" class="btn-back">
                        ← <?= isset($article['meta']['category']) && $article['meta']['category'] ? 'К категории ' . htmlspecialchars($article['meta']['category']) : 'Все статьи' ?>
                    </a>
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

            .article-category-badge {
                display: inline-block;
                background: #667eea;
                color: white;
                padding: 0.4rem 1rem;
                border-radius: 15px;
                font-size: 0.8rem;
                font-weight: 500;
                margin-bottom: 1rem;
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
                flex-wrap: wrap;
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

            @media (max-width: 768px) {
                .article-detail {
                    padding: 1rem;
                }

                .article-header h1 {
                    font-size: 2rem;
                }

                .article-meta {
                    gap: 1rem;
                    font-size: 0.9rem;
                }
            }
        </style>
        <?php
    }

    private function renderCategoriesPage($categories)
    {
        $contentParser = new \App\Core\ContentParser();
        ?>
        <div class="categories-page">
            <div class="page-header">
                <h1>📂 Категории статей</h1>
                <p class="page-description">Все категории нашего сайта с количеством статей</p>
            </div>

            <?php if (!empty($categories)): ?>
                <div class="categories-grid">
                    <?php foreach ($categories as $category): ?>
                        <?php
                        $articlesCount = $contentParser->getArticlesCountByCategory($category['name']);
                        if ($articlesCount > 0):
                            ?>
                            <div class="category-card" style="border-left: 4px solid <?= htmlspecialchars($category['color']) ?>;">
                                <div class="category-header">
                                    <span class="category-icon"><?= htmlspecialchars($category['icon']) ?></span>
                                    <h3><?= htmlspecialchars($category['name']) ?></h3>
                                </div>

                                <p class="category-description"><?= htmlspecialchars($category['description']) ?></p>

                                <div class="category-footer">
                                    <span class="articles-count"><?= $articlesCount ?> <?= $this->getArticleWord($articlesCount) ?></span>
                                    <a href="/articles?category=<?= urlencode($category['name']) ?>" class="view-category">
                                        Смотреть →
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-categories">
                    <p>😔 Категории пока не добавлены</p>
                </div>
            <?php endif; ?>
        </div>

        <style>
            .categories-page {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .page-header {
                margin-bottom: 2rem;
                text-align: center;
            }

            .page-header h1 {
                margin: 0 0 0.5rem 0;
                font-size: 2rem;
                color: #333;
            }

            .page-description {
                margin: 0;
                color: #666;
                font-size: 1.1rem;
            }

            .categories-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 20px;
            }

            .category-card {
                background: white;
                padding: 1.5rem;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                transition: transform 0.3s;
            }

            .category-card:hover {
                transform: translateY(-3px);
            }

            .category-header {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 1rem;
            }

            .category-icon {
                font-size: 1.5rem;
            }

            .category-header h3 {
                margin: 0;
                color: #333;
                font-size: 1.2rem;
            }

            .category-description {
                color: #666;
                line-height: 1.5;
                margin-bottom: 1rem;
            }

            .category-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .articles-count {
                color: #666;
                font-size: 0.9rem;
            }

            .view-category {
                color: #667eea;
                text-decoration: none;
                font-weight: 500;
                transition: color 0.3s;
            }

            .view-category:hover {
                color: #5a6fd8;
            }

            .no-categories {
                text-align: center;
                padding: 60px 20px;
                color: #666;
            }

            @media (max-width: 768px) {
                .categories-page {
                    padding: 1rem;
                }

                .categories-grid {
                    grid-template-columns: 1fr;
                }
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

    private function getArticleWord($count)
    {
        if ($count % 10 == 1 && $count % 100 != 11) {
            return 'статья';
        } elseif (in_array($count % 10, [2,3,4]) && !in_array($count % 100, [12,13,14])) {
            return 'статьи';
        } else {
            return 'статей';
        }
    }

    public function show404()
    {
        http_response_code(404);
        $this->render('404');
    }
}