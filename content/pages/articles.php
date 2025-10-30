<?php
$articles = $articles ?? [];
$categories = $categories ?? [];
$current_category = $current_category ?? null;
$category_info = $category_info ?? null;
$title = $title ?? 'Статьи';
$helper = new \App\Core\Helper();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $helper::sanitize($title) ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
        }

        .back-link {
            color: #667eea;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: white;
            transition: all 0.3s ease;
            grid-column: 1 / -1;
        }

        .back-link:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .sidebar {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            height: fit-content;
        }

        .sidebar-title {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .categories-list {
            list-style: none;
        }

        .category-item {
            margin-bottom: 0.5rem;
        }

        .category-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            color: #666;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .category-link:hover, .category-link.active {
            background: #667eea;
            color: white;
        }

        .category-count {
            margin-left: auto;
            background: rgba(255,255,255,0.2);
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
        }

        .main-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .page-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .page-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .page-description {
            color: #666;
            font-size: 1.1rem;
        }

        .articles-grid {
            display: grid;
            gap: 1.5rem;
        }

        .article-card {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            background: white;
        }

        .article-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-color: #667eea;
        }

        .article-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .article-title {
            font-size: 1.4rem;
            color: #333;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .article-title a {
            color: inherit;
            text-decoration: none;
        }

        .article-title a:hover {
            color: #667eea;
        }

        .article-category {
            background: #667eea;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            white-space: nowrap;
        }

        .article-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .article-meta {
            display: flex;
            gap: 1rem;
            color: #888;
            font-size: 0.9rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .read-more {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .read-more:hover {
            text-decoration: underline;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #666;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .sidebar {
                order: 2;
            }

            .main-content {
                order: 1;
                padding: 1.5rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .article-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .article-category {
                align-self: flex-start;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <a href="/" class="back-link">
        ← На главную
    </a>

    <!-- Боковая панель с категориями -->
    <aside class="sidebar">
        <h2 class="sidebar-title">📂 Категории</h2>
        <ul class="categories-list">
            <li class="category-item">
                <a href="/articles" class="category-link <?= !$current_category ? 'active' : '' ?>">
                    📚 Все статьи
                    <span class="category-count"><?= count($articles) ?></span>
                </a>
            </li>
            <?php foreach ($categories as $category): ?>
                <li class="category-item">
                    <a href="/articles/category/<?= $helper::sanitize($category['name']) ?>"
                       class="category-link <?= $current_category === $category['name'] ? 'active' : '' ?>">
                        <?= $helper::sanitize($category['icon']) ?> <?= $helper::sanitize($category['name']) ?>
                        <span class="category-count"><?= $category['article_count'] ?? 0 ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <!-- Основной контент -->
    <main class="main-content">
        <header class="page-header">
            <h1 class="page-title"><?= $helper::sanitize($title) ?></h1>
            <?php if ($category_info && isset($category_info['description'])): ?>
                <p class="page-description"><?= $helper::sanitize($category_info['description']) ?></p>
            <?php endif; ?>
        </header>

        <?php if (!empty($articles)): ?>
            <div class="articles-grid">
                <?php foreach ($articles as $article): ?>
                    <article class="article-card">
                        <div class="article-header">
                            <div>
                                <h2 class="article-title">
                                    <a href="/article/<?= $helper::sanitize($article['slug']) ?>">
                                        <?= $helper::sanitize($article['title']) ?>
                                    </a>
                                </h2>
                            </div>
                            <?php if (isset($article['meta']['category']) && $article['meta']['category']): ?>
                                <div class="article-category" style="background: <?= $helper::sanitize($article['category_info']['color'] ?? '#667eea') ?>;">
                                    <?= $helper::sanitize($article['category_info']['icon'] ?? '📁') ?> <?= $helper::sanitize($article['meta']['category']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <p class="article-excerpt">
                            <?= $helper::sanitize($article['excerpt'] ?? 'Описание статьи отсутствует') ?>
                        </p>

                        <div class="article-meta">
                            <span class="meta-item">👤 <?= $helper::sanitize($article['meta']['author'] ?? 'Автор') ?></span>
                            <span class="meta-item">📅 <?= $helper::formatDate($article['meta']['date'] ?? '', 'd.m.Y') ?></span>
                            <span class="meta-item">⏱️ ~5 мин</span>
                        </div>

                        <a href="/article/<?= $helper::sanitize($article['slug']) ?>" class="read-more">
                            Читать далее →
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>Статьи не найдены</h3>
                <p>В этой категории пока нет статей.</p>
                <a href="/articles" class="read-more">Вернуться ко всем статьям</a>
            </div>
        <?php endif; ?>
    </main>
</div>

<script>
    // Автоматический расчет времени чтения для каждой статьи
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.article-card').forEach(card => {
            const excerpt = card.querySelector('.article-excerpt');
            if (excerpt) {
                const text = excerpt.textContent || excerpt.innerText;
                const wordCount = text.trim().split(/\s+/).length;
                const readingTime = Math.max(1, Math.ceil(wordCount / 200));

                const timeElement = card.querySelector('.meta-item:last-child');
                if (timeElement) {
                    timeElement.textContent = `⏱️ ~${readingTime} мин`;
                }
            }
        });
    });
</script>
</body>
</html>