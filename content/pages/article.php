<div style="margin-bottom: 1rem;">
    <a href="/articles" style="
        color: #667eea;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    ">← Назад к статьям</a>
</div>

<?php if (isset($article) && !empty($article)): ?>
    <article style="
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
">
        <header style="margin-bottom: 2rem; border-bottom: 2px solid #f0f0f0; padding-bottom: 1.5rem;">
            <h1 style="
            font-size: 2.2rem;
            color: #333;
            margin-bottom: 1rem;
            line-height: 1.3;
        "><?= htmlspecialchars($article['meta']['title'] ?? $article['title'] ?? 'Статья без названия') ?></h1>

            <div style="
            display: flex;
            gap: 2rem;
            color: #666;
            font-size: 0.95rem;
        ">
            <span style="display: flex; align-items: center; gap: 0.5rem;">
                👤 <?= htmlspecialchars($article['meta']['author'] ?? 'Автор') ?>
            </span>
                <span style="display: flex; align-items: center; gap: 0.5rem;">
                📅 <?= \App\Core\Helper::formatDate($article['meta']['date'] ?? '', 'd.m.Y в H:i') ?>
            </span>
                <span style="display: flex; align-items: center; gap: 0.5rem;">
                ⏱️ Время чтения: ~5 мин
            </span>
            </div>
        </header>

        <div style="
        line-height: 1.8;
        color: #444;
        font-size: 1.1rem;
    ">
            <?= $article['content'] ?? 'Контент статьи отсутствует' ?>
        </div>

        <footer style="
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    ">
            <a href="/articles" style="
            color: #667eea;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        ">← Все статьи</a>

            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" style="
            background: #667eea;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        ">↑ Наверх</button>
        </footer>
    </article>
<?php else: ?>
    <div style="
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    color: #666;
">
        <div style="font-size: 4rem; margin-bottom: 1rem;">😕</div>
        <h2 style="margin-bottom: 1rem;">Статья не найдена</h2>
        <p>Извините, но запрашиваемая статья не существует или была удалена.</p>
        <a href="/articles" style="
        display: inline-block;
        background: #667eea;
        color: white;
        padding: 1rem 2rem;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 1rem;
    ">Вернуться к статьям</a>
    </div>
<?php endif; ?>