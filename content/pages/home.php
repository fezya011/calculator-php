<div style="
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 2rem;
    border-radius: 15px;
    text-align: center;
    margin-bottom: 3rem;
">
    <h1 style="font-size: 3rem; margin-bottom: 1rem;">Добро пожаловать в FlatCMS</h1>
    <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">
        Простая и эффективная система управления контентом
    </p>
    <a href="/articles" style="
        display: inline-block;
        background: white;
        color: #667eea;
        padding: 1rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: transform 0.3s;
    " onmouseover="this.style.transform='translateY(-2px)'"
       onmouseout="this.style.transform='translateY(0)'">
        📖 Читать статьи
    </a>
</div>

<h2 style="
    text-align: center;
    margin-bottom: 2rem;
    color: #333;
    font-size: 2rem;
">🔥 Последние статьи</h2>

<div style="display: grid; gap: 1.5rem;">
    <?php if (isset($articles) && !empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <div style="
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        " onmouseover="this.style.transform='translateY(-5px)'"
                 onmouseout="this.style.transform='translateY(0)'">

                <h3 style="margin-bottom: 1rem;">
                    <a href="/article/<?= $article['meta']['slug'] ?? '' ?>" style="
                    color: #333;
                    text-decoration: none;
                    font-size: 1.3rem;
                "><?= htmlspecialchars($article['meta']['title'] ?? 'Без названия') ?></a>
                </h3>

                <div style="
                display: flex;
                gap: 1rem;
                margin-bottom: 1rem;
                color: #666;
                font-size: 0.9rem;
            ">
                    <span>👤 <?= htmlspecialchars($article['meta']['author'] ?? 'Автор') ?></span>
                    <span>📅 <?= \App\Core\Helper::formatDate($article['meta']['date'] ?? '') ?></span>
                </div>

                <p style="color: #555; line-height: 1.6; margin-bottom: 1rem;">
                    <?= \App\Core\Helper::truncate(strip_tags($article['content'] ?? ''), 150) ?>
                </p>

                <a href="/article/<?= $article['meta']['slug'] ?? '' ?>" style="
                display: inline-block;
                background: #667eea;
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 5px;
                text-decoration: none;
                font-size: 0.9rem;
            ">Читать далее →</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 10px;
        color: #666;
    ">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
            <h3 style="margin-bottom: 0.5rem;">Статьи пока не добавлены</h3>
            <p>Администратор еще не опубликовал ни одной статьи.</p>
        </div>
    <?php endif; ?>
</div>