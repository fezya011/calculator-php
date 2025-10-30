<?php
$article = $article ?? [];
$title = $title ?? 'Статья';
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

        .article-container {
            max-width: 800px;
            margin: 0 auto;
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
        }

        .back-link:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .article-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: relative;
        }

        .article-category {
            position: absolute;
            top: -10px;
            right: 2rem;
            background: #667eea;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .article-header {
            margin-bottom: 2rem;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 1.5rem;
        }

        .article-title {
            font-size: 2.2rem;
            color: #333;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .article-meta {
            display: flex;
            gap: 2rem;
            color: #666;
            font-size: 0.95rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .category-link {
            color: #667eea;
            text-decoration: none;
        }

        .category-link:hover {
            text-decoration: underline;
        }

        .article-body {
            line-height: 1.8;
            color: #444;
            font-size: 1.1rem;
        }

        .article-body h1,
        .article-body h2,
        .article-body h3 {
            margin: 2rem 0 1rem 0;
            color: #333;
        }

        .article-body p {
            margin-bottom: 1rem;
        }

        .article-body ul,
        .article-body ol {
            margin: 1rem 0;
            padding-left: 2rem;
        }

        .article-body code {
            background: #f1f5f9;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }

        .article-body pre {
            background: #1a202c;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 6px;
            overflow-x: auto;
            margin: 1rem 0;
        }

        .article-footer {
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-link {
            color: #667eea;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .scroll-top {
            background: #667eea;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.3s ease;
        }

        .scroll-top:hover {
            background: #5a6fd8;
        }

        .not-found {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            color: #666;
        }

        .not-found-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .not-found-link {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .not-found-link:hover {
            background: #5a6fd8;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .article-content {
                padding: 1.5rem;
            }

            .article-title {
                font-size: 1.8rem;
            }

            .article-meta {
                gap: 1rem;
                font-size: 0.9rem;
            }

            .article-body {
                font-size: 1rem;
            }

            .article-footer {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>
<div class="article-container">
    <a href="<?= isset($article['meta']['category']) && $article['meta']['category'] ? '/articles/category/' . $helper::sanitize($article['meta']['category']) : '/articles' ?>" class="back-link">
        ← Назад к статьям
    </a>

    <?php if (isset($article) && !empty($article) && isset($article['title'])): ?>
        <article class="article-content">
            <!-- Категория статьи -->
            <?php if (isset($article['meta']['category']) && $article['meta']['category']): ?>
                <div class="article-category" style="background: <?= $helper::sanitize($article['category_info']['color'] ?? '#667eea') ?>;">
                    <?= $helper::sanitize($article['category_info']['icon'] ?? '📁') ?> <?= $helper::sanitize($article['meta']['category']) ?>
                </div>
            <?php endif; ?>

            <header class="article-header">
                <h1 class="article-title"><?= $helper::sanitize($article['title'] ?? 'Статья без названия') ?></h1>

                <div class="article-meta">
                    <span class="meta-item">
                        👤 <?= $helper::sanitize($article['meta']['author'] ?? 'Автор') ?>
                    </span>
                    <span class="meta-item">
                        📅 <?= isset($article['meta']['date']) ? $helper::formatDate($article['meta']['date'], 'd.m.Y в H:i') : 'Дата не указана' ?>
                    </span>
                    <?php if (isset($article['meta']['category']) && $article['meta']['category']): ?>
                        <span class="meta-item">
                            <?= $helper::sanitize($article['category_info']['icon'] ?? '📁') ?>
                            <a href="/articles/category/<?= $helper::sanitize($article['meta']['category']) ?>" class="category-link">
                                <?= $helper::sanitize($article['meta']['category']) ?>
                            </a>
                        </span>
                    <?php endif; ?>
                    <span class="meta-item" id="reading-time">
                        ⏱️ Время чтения: ~5 мин
                    </span>
                </div>
            </header>

            <div class="article-body">
                <?= $article['content'] ?? 'Контент статьи отсутствует' ?>
            </div>

            <footer class="article-footer">
                <a href="<?= isset($article['meta']['category']) && $article['meta']['category'] ? '/articles/category/' . $helper::sanitize($article['meta']['category']) : '/articles' ?>" class="footer-link">
                    ← <?= isset($article['meta']['category']) && $article['meta']['category'] ? 'К категории ' . $helper::sanitize($article['meta']['category']) : 'Все статьи' ?>
                </a>

                <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="scroll-top">
                    ↑ Наверх
                </button>
            </footer>
        </article>
    <?php else: ?>
        <div class="not-found">
            <div class="not-found-icon">😔</div>
            <h3 style="margin-bottom: 0.5rem;">Статья не найдена</h3>
            <p style="color: #666; margin-bottom: 1.5rem;">
                Запрошенная статья не существует или была удалена.
            </p>
            <a href="/articles" class="not-found-link">📚 Вернуться к статьям</a>
        </div>
    <?php endif; ?>
</div>

<script>
    // Автоматический расчет времени чтения
    document.addEventListener('DOMContentLoaded', function() {
        const articleBody = document.querySelector('.article-body');
        if (articleBody) {
            const text = articleBody.textContent || articleBody.innerText;
            const words = text.trim().split(/\s+/).filter(word => word.length > 0);
            const wordCount = words.length;
            const readingTime = Math.max(1, Math.ceil(wordCount / 200));

            const timeElement = document.getElementById('reading-time');
            if (timeElement && readingTime > 0) {
                timeElement.innerHTML = `⏱️ Время чтения: ~${readingTime} мин`;
            }
        }
    });
</script>
</body>
</html>