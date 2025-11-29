<?php
namespace App\Core;

class ContentParser
{
    public $file_manager;
    public $helper;

    public function __construct()
    {
        $this->file_manager = new FileManager();
        $this->helper = new Helper();
    }

    public function getPage($name)
    {
        $file = ROOT_DIR."/content/pages/{$name}.php";

        if (!file_exists($file)) {
            return null;
        }

        ob_start();
        include $file;
        $content = ob_get_clean();

        preg_match('/<h1[^>]*>(.*?)<\/h1>/', $content, $matches);
        $title = $matches[1] ?? ucfirst($name);

        return [
            'title' => $title,
            'content' => $content
        ];
    }

    public function getArticle($slug)
    {
        $file = ROOT_DIR."/content/articles/{$slug}.md";

        if (!file_exists($file)) {
            return null;
        }

        $content = file_get_contents($file);

        $parsed = $this->parseMarkdownWithFrontMatter($content);


        // Генерируем УНИКАЛЬНЫЙ ID на основе slug и содержимого файла
        $id = md5($slug . filemtime($file));

        $coverImage = $parsed['meta']['cover_image'] ?? null;

        return [
            'id' => $id,
            'slug' => $slug,
            'title' => $parsed['meta']['title'] ?? 'Статья',
            'content' => $parsed['content'],
            'meta' => $parsed['meta'],
            'excerpt' => $this->helper::getExcerpt($parsed['content']),
            'category_info' => $this->getCategoryInfo($parsed['meta']['category'] ?? ''),
            'image' => $coverImage
        ];
    }


    public function getArticles($limit = null, $category = null)
    {
        $articles = [];
        $contentPath = ROOT_DIR . '/content/articles/';

        if (!is_dir($contentPath)) {
            return $articles;
        }

        $files = glob($contentPath . '*.md');

        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        foreach ($files as $file) {
            $slug = pathinfo($file, PATHINFO_FILENAME);
            $content = file_get_contents($file);
            $parsed = $this->parseMarkdownWithFrontMatter($content);

            // Фильтрация по категории
            if ($category && ($parsed['meta']['category'] ?? '') !== $category) {
                continue;
            }

            // Генерируем УНИКАЛЬНЫЙ ID для каждой статьи
            $id = md5($slug . filemtime($file));
            $categoryName = $parsed['meta']['category'] ?? 'Без категории';

            $articles[] = [
                'id' => $id,
                'slug' => $slug,
                'title' => $parsed['meta']['title'] ?? 'Статья',
                'content' => $parsed['content'],
                'meta' => $parsed['meta'],
                'excerpt' => $this->helper::getExcerpt($parsed['content']),
                'category_info' => $this->getCategoryInfo($categoryName),
                'image' => $parsed['meta']['cover_image'] ?? null
            ];
        }

        if ($limit) {
            $articles = array_slice($articles, 0, $limit);
        }

        return $articles;
    }

    public function getCategories()
    {
        $categories = [];
        $categoriesFile = ROOT_DIR . '/content/categories.md';

        // Читаем категории из файла
        if (file_exists($categoriesFile)) {
            $content = file_get_contents($categoriesFile);
            $lines = explode("\n", $content);

            foreach ($lines as $line) {
                $line = trim($line);
                // Пропускаем комментарии и пустые строки
                if (empty($line) || strpos($line, '#') === 0) {
                    continue;
                }

                $parts = explode('|', $line);
                if (count($parts) >= 4) {
                    $categories[] = [
                        'name' => trim($parts[0]),
                        'description' => trim($parts[1]),
                        'color' => trim($parts[2]),
                        'icon' => trim($parts[3])
                    ];
                }
            }
        }

        // Если файла нет, создаем категории из статей
        if (empty($categories)) {
            $categories = $this->getCategoriesFromArticles();
        }

        return $categories;
    }

    private function getCategoriesFromArticles()
    {
        $categories = [];
        $contentPath = ROOT_DIR . '/content/articles/';

        if (!is_dir($contentPath)) {
            return $categories;
        }

        $files = glob($contentPath . '*.md');

        foreach ($files as $file) {
            $content = file_get_contents($file);
            $parsed = $this->parseMarkdownWithFrontMatter($content);

            $categoryName = $parsed['meta']['category'] ?? 'Без категории';

            if (!isset($categories[$categoryName])) {
                $categories[$categoryName] = [
                    'name' => $categoryName,
                    'description' => 'Статьи в категории ' . $categoryName,
                    'color' => $this->getRandomColor(),
                    'icon' => '📁'
                ];
            }
        }

        return array_values($categories);
    }

    public function getCategoryInfo($categoryName)
    {
        $categories = $this->getCategories();

        foreach ($categories as $category) {
            if ($category['name'] === $categoryName) {
                return $category;
            }
        }

        // Если категория не найдена, возвращаем базовую информацию
        return [
            'name' => $categoryName,
            'description' => 'Статьи в категории ' . $categoryName,
            'color' => '#667eea',
            'icon' => '📁'
        ];
    }

    public function getArticlesByCategory($category)
    {
        return $this->getArticles(null, $category);
    }

    public function getCategoriesWithCounts(): array
    {
        $categories = $this->getCategories();
        $allArticles = $this->getArticles();

        foreach ($categories as &$category) {
            $category['articles_count'] = count(array_filter($allArticles, function($article) use ($category) {
                return ($article['meta']['category'] ?? '') === $category['name'];
            }));
        }

        return $categories;
    }


    private function getRandomColor()
    {
        $colors = ['#e74c3c', '#3498db', '#9b59b6', '#2ecc71', '#f39c12',
            '#1abc9c', '#e67e22', '#c0392b', '#7f8c8d', '#8e44ad'];
        return $colors[array_rand($colors)];
    }

    private function parseMarkdownWithFrontMatter($content)
    {
        $pattern = '/^---\s*(.*?)\s*---\s*(.*)$/s';

        if (preg_match($pattern, $content, $matches)) {
            $frontMatter = $this->parseYaml($matches[1]);
            $body = trim($matches[2]);
            return [
                'meta' => $frontMatter,
                'content' => $this->file_manager->parseToHtml($body)
            ];
        }

        return [
            'meta' => [],
            'content' => $this->file_manager->parseToHtml($content)
        ];
    }

    private function parseYaml($yaml)
    {
        $lines = explode("\n", $yaml);
        $data = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line, 2);
                $key = trim($key);
                $value = trim($value);

                if ($key === 'date' && strtotime($value)) {
                    $value = date('Y-m-d', strtotime($value));
                }

                $data[$key] = $value;
            }
        }

        return $data;
    }
}