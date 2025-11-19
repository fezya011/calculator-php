<h1 style="
    font-size: 2.5rem;
    margin-bottom: 2rem;
    color: #333;
    text-align: center;
">📚 Все статьи</h1>

<div style="display: grid; gap: 1.5rem;">
    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <div style="
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #667eea;
        ">
                <h2 style="margin-bottom: 1rem; font-size: 1.5rem;">
                    <a href="/article/<?= $article['meta']['slug'] ?>" style="
                    color: #333;
                    text-decoration: none;
                "><?= htmlspecialchars($article['meta']['title']) ?></a>
                </h2>

                <div style="
                display: flex;
                gap: 1.5rem;
                margin-bottom: 1rem;
                color: #666;
                font-size: 0.9rem;
            ">
                    <span>👤 <?= htmlspecialchars($article['meta']['author']) ?></span>
                    <span>📅 <?= \App\Core\Helper::formatDate($article['meta']['date']) ?></span>
                </div>

                <p style="color: #555; line-height: 1.6; margin-bottom: 1.5rem;">
                    <?= \App\Core\Helper::truncate(strip_tags($article['content']), 200) ?>
                </p>

                <a href="/article/<?= $article['meta']['slug'] ?>" style="
                display: inline-block;
                background: #667eea;
                color: white;
                padding: 0.75rem 1.5rem;
                border-radius: 6px;
                text-decoration: none;
                font-weight: 500;
                transition: background 0.3s;
            " onmouseover="this.style.background='#5a6fd8'"
                   onmouseout="this.style.background='#667eea'">
                    Читать статью →
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 10px;
            color: #666;
        ">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🔍</div>
            <h2 style="margin-bottom: 1rem;">Статьи не найдены</h2>
            <p>Попробуйте зайти позже, когда статьи будут добавлены.</p>
        </div>
    <?php endif; ?>
</div>