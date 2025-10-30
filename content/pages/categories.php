<h1>📁 Категории статей</h1>

<div style="
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
">
    <?php if (!empty($categories)): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
            <?php foreach ($categories as $category): ?>
                <?php
                $categoryArticles = $this->parser->getArticlesByCategory($category['name']);
                $articlesCount = count($categoryArticles);
                ?>
                <?php if ($articlesCount > 0): ?>
                    <a href="/articles?category=<?= urlencode($category['name']) ?>" style="
                            display: block;
                            background: linear-gradient(135deg, <?= $category['color'] ?> 0%, <?= $this->darkenColor($category['color'], 15) ?> 100%);
                            padding: 1.5rem;
                            border-radius: 12px;
                            text-decoration: none;
                            color: white;
                            transition: all 0.3s;
                            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                            " onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <span style="font-size: 2rem;"><?= $category['icon'] ?></span>
                            <div>
                                <h3 style="margin: 0 0 0.25rem 0; font-size: 1.3rem; font-weight: 600;"><?= $category['name'] ?></h3>
                                <p style="margin: 0; opacity: 0.9; font-size: 0.9rem;"><?= $category['description'] ?></p>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">
                            <?= $articlesCount ?> <?= $this->getArticleWord($articlesCount) ?>
                        </span>
                            <span style="font-size: 0.9rem; opacity: 0.9;">→</span>
                        </div>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 3rem; color: #666;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📭</div>
            <h3 style="margin-bottom: 1rem;">Категории не найдены</h3>
            <p>Добавьте файл <code>content/categories.md</code> с описанием категорий</p>
        </div>
    <?php endif; ?>
</div>

<?php
// Вспомогательная функция для правильного склонения
function getArticleWord($count) {
    if ($count % 10 == 1 && $count % 100 != 11) {
        return 'статья';
    } elseif (in_array($count % 10, [2,3,4]) && !in_array($count % 100, [12,13,14])) {
        return 'статьи';
    } else {
        return 'статей';
    }
}

// Функция для затемнения цвета
function darkenColor($color, $percent) {
    $color = str_replace('#', '', $color);
    $r = hexdec(substr($color, 0, 2));
    $g = hexdec(substr($color, 2, 2));
    $b = hexdec(substr($color, 4, 2));

    $r = max(0, min(255, $r - ($r * $percent / 100)));
    $g = max(0, min(255, $g - ($g * $percent / 100)));
    $b = max(0, min(255, $b - ($b * $percent / 100)));

    return sprintf("#%02x%02x%02x", $r, $g, $b);
}
?>