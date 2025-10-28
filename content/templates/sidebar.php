<div style="
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: sticky;
    top: 20px;
">
    <h3 style="
        color: #667eea;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f0f0f0;
    ">📚 Последние статьи</h3>

    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <?php
        $contentParser = new \App\Core\ContentParser();
        $recentArticles = $contentParser->getArticles(5);
        foreach ($recentArticles as $article):
            ?>
            <div style="
                padding: 0.75rem;
                background: #f8f9fa;
                border-radius: 5px;
                border-left: 3px solid #667eea;
            ">
                <a href="/article/<?= $article['meta']['slug'] ?? '' ?>" style="
                    color: #333;
                    text-decoration: none;
                    font-weight: 500;
                    display: block;
                    margin-bottom: 0.25rem;
                ">
                    <?= \App\Core\Helper::truncate($article['title'] ?? 'Без названия', 40) ?>
                </a>
                <small style="color: #666; font-size: 0.8rem;">
                    📅 <?= \App\Core\Helper::formatDate($article['meta']['date'] ?? '') ?>
                </small>
            </div>
        <?php endforeach; ?>

        <?php if (empty($recentArticles)): ?>
            <div style="
                text-align: center;
                color: #666;
                padding: 1rem;
            ">
                <p>Статьи пока не добавлены</p>
            </div>
        <?php endif; ?>
    </div>

    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #eee;">
        <h4 style="color: #667eea; margin-bottom: 0.5rem;">ℹ️ О сайте</h4>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: 1rem;">
            Простая CMS без базы данных. Хранение данных в файлах.
        </p>
        <a href="/about" style="
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
        ">Подробнее</a>
    </div>
</div>