<div style="
    background: white;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    position: sticky;
    top: 20px;
    margin-right: 2rem;
    width: 250px;
">
    <!-- Категории -->
    <h4 style="
    color: #667eea;
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.9rem;
">📁 Категории</h4>

    <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem; max-height: 300px; overflow-y: auto;">
        <?php
        $contentParser = new \App\Core\ContentParser();
        $categories = $contentParser->getCategories();
        $current_category = $_GET['category'] ?? '';
        ?>

        <a href="/articles" style="
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.5rem 0.6rem;
                background: <?= $current_category === '' ? '#667eea' : '#f8f9fa' ?>;
                color: <?= $current_category === '' ? 'white' : '#333' ?>;
                text-decoration: none;
                border-radius: 6px;
                font-size: 0.8rem;
                transition: all 0.2s;
                border: 1px solid <?= $current_category === '' ? '#667eea' : '#e9ecef' ?>;
                " onmouseover="this.style.background='<?= $current_category === '' ? '#5a6fd8' : '#e9ecef' ?>'"
           onmouseout="this.style.background='<?= $current_category === '' ? '#667eea' : '#f8f9fa' ?>'">
            <span style="font-size: 1rem;">📚</span>
            <span style="flex: 1;">Все статьи</span>
            <small style="opacity: 0.7;"><?= count($contentParser->getArticles()) ?></small>
        </a>

        <?php foreach ($categories as $category): ?>
            <?php
            $articlesCount = $contentParser->getArticlesCountByCategory($category['name']);
            if ($articlesCount > 0):
                ?>
                <a href="/articles?category=<?= urlencode($category['name']) ?>" style="
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                        padding: 0.5rem 0.6rem;
                        background: <?= $current_category === $category['name'] ? $category['color'] : '#f8f9fa' ?>;
                        color: <?= $current_category === $category['name'] ? 'white' : '#333' ?>;
                        text-decoration: none;
                        border-radius: 6px;
                        font-size: 0.8rem;
                        transition: all 0.2s;
                        border: 1px solid <?= $current_category === $category['name'] ? $category['color'] : '#e9ecef' ?>;
                        " onmouseover="this.style.background='<?= $current_category === $category['name'] ? $this->darkenColor($category['color'], 10) : '#e9ecef' ?>'"
                   onmouseout="this.style.background='<?= $current_category === $category['name'] ? $category['color'] : '#f8f9fa' ?>'"
                   title="<?= htmlspecialchars($category['description']) ?>">
                    <span style="font-size: 1rem;"><?= $category['icon'] ?></span>
                    <span style="flex: 1;"><?= htmlspecialchars($category['name']) ?></span>
                    <small style="opacity: 0.7;"><?= $articlesCount ?></small>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Последние статьи -->
    <h4 style="
        color: #667eea;
        margin-bottom: 0.75rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.9rem;
    ">🔥 Последние</h4>

    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
        <?php
        $recentArticles = $contentParser->getArticles(3);
        foreach ($recentArticles as $article):
            $categoryInfo = $contentParser->getCategoryInfo($article['meta']['category'] ?? '');
            ?>
            <a href="/article/<?= htmlspecialchars($article['slug'] ?? '') ?>" style="
                    display: block;
                    padding: 0.5rem 0.6rem;
                    background: #f8f9fa;
                    border-radius: 6px;
                    text-decoration: none;
                    font-size: 0.75rem;
                    line-height: 1.3;
                    transition: all 0.2s;
                    border-left: 3px solid <?= $categoryInfo['color'] ?? '#667eea' ?>;
                    " onmouseover="this.style.background='#e9ecef'; this.style.transform='translateX(2px)'"
               onmouseout="this.style.background='#f8f9fa'; this.style.transform='translateX(0)'">
                <div style="color: #333; font-weight: 500; margin-bottom: 0.2rem;">
                    <?= \App\Core\Helper::truncate($article['title'] ?? 'Без названия', 25) ?>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <small style="color: #666;">
                        <?= $categoryInfo['icon'] ?? '📁' ?> <?= \App\Core\Helper::truncate($article['meta']['category'] ?? 'Общее', 12) ?>
                    </small>
                    <small style="color: #999;">
                        <?= \App\Core\Helper::formatDate($article['meta']['date'] ?? '') ?>
                    </small>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // Функция для затемнения цвета (для hover эффектов)
    function darkenColor(color, percent) {
        var num = parseInt(color.replace("#",""), 16),
            amt = Math.round(2.55 * percent),
            R = (num >> 16) - amt,
            G = (num >> 8 & 0x00FF) - amt,
            B = (num & 0x0000FF) - amt;
        return "#" + (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (G<255?G<1?0:G:255)*0x100 + (B<255?B<1?0:B:255)).toString(16).slice(1);
    }
</script>