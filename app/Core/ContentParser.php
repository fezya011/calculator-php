<?php
namespace App\Core;

use Parsedown;

class ContentParser
{
    private Parsedown $md_parser;

    public function __construct()
    {
        $this->md_parser = new Parsedown();
        $this->md_parser->setSafeMode(true);
    }

    public function getPage(string $name): ?array
    {
        $file = ROOT_DIR . "/content/pages/{$name}.php";

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

    public function getArticle(string $slug): ?array
    {
        $file = ROOT_DIR . "/content/articles/{$slug}.md";

        if (!file_exists($file)) {
            return null;
        }

        $content = file_get_contents($file);
        $parsed = $this->parseContent($content);

        return [
            'slug' => $slug,
            'title' => $parsed['meta']['title'] ?? ucfirst($slug),
            'content' => $parsed['content'],
            'meta' => $parsed['meta'],
            'excerpt' => $this->getExcerpt(strip_tags($parsed['content'])),
            'category_info' => $this->getCategoryInfo($parsed['meta']['category'] ?? ''),
            'image' => $parsed['meta']['cover_image'] ?? null,
            'date' => $parsed['meta']['date'] ?? date('Y-m-d', filemtime($file))
        ];
    }

    public function getArticles(?int $limit = null, ?string $category = null): array
    {
        $files = glob(ROOT_DIR . '/content/articles/*.md') ?: [];
        $articles = [];

        foreach ($files as $file) {
            $slug = pathinfo($file, PATHINFO_FILENAME);
            $content = file_get_contents($file);
            $parsed = $this->parseContent($content);

            if ($category && ($parsed['meta']['category'] ?? '') !== $category) {
                continue;
            }

            $articles[] = [
                'slug' => $slug,
                'title' => $parsed['meta']['title'] ?? ucfirst($slug),
                'content' => $parsed['content'],
                'meta' => $parsed['meta'],
                'excerpt' => $this->getExcerpt(strip_tags($parsed['content'])),
                'category_info' => $this->getCategoryInfo($parsed['meta']['category'] ?? ''),
                'image' => $parsed['meta']['cover_image'] ?? null,
                'date' => $parsed['meta']['date'] ?? date('Y-m-d', filemtime($file))
            ];

            if ($limit && count($articles) >= $limit) {
                break;
            }
        }

        usort($articles, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));
        return $articles;
    }

    public function getArticlesByCategory(string $category): array
    {
        return $this->getArticles(null, $category);
    }

    public function getCategories(): array
    {
        $categoriesFile = ROOT_DIR . '/content/categories.md';
        $categories = [];

        if (file_exists($categoriesFile)) {
            $content = file_get_contents($categoriesFile);
            $lines = explode("\n", $content);

            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line) || str_starts_with($line, '#')) continue;

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

        return empty($categories) ? $this->extractCategoriesFromArticles() : $categories;
    }

    public function getCategoriesWithCounts(): array
    {
        $categories = $this->getCategories();
        $articles = $this->getArticles();

        foreach ($categories as &$category) {
            $category['articles_count'] = count(array_filter($articles,
                fn($article) => ($article['meta']['category'] ?? '') === $category['name']
            ));
        }

        return $categories;
    }

    private function parseContent(string $content): array
    {
        if (preg_match('/^---\s*\R(.*?)\R---\s*\R?(.*)$/s', $content, $matches)) {
            return [
                'meta' => $this->parseFrontMatter($matches[1]),
                'content' => $this->md_parser->text(trim($matches[2]))
            ];
        }

        return [
            'meta' => [],
            'content' => $this->md_parser->text(trim($content))
        ];
    }

    private function parseFrontMatter(string $yaml): array
    {
        $data = [];

        foreach (explode("\n", $yaml) as $line) {
            $line = trim($line);
            if (empty($line) || !str_contains($line, ':')) continue;

            [$key, $value] = explode(':', $line, 2);
            $data[trim($key)] = trim(trim($value), '"\'');
        }

        return $data;
    }

    private function getCategoryInfo(string $categoryName): array
    {
        $categories = $this->getCategories();

        foreach ($categories as $category) {
            if ($category['name'] === $categoryName) {
                return $category;
            }
        }

        return [
            'name' => $categoryName,
            'description' => 'Статьи в категории ' . $categoryName,
            'color' => '#667eea',
            'icon' => '📁'
        ];
    }

    private function extractCategoriesFromArticles(): array
    {
        $categories = [];
        $files = glob(ROOT_DIR . '/content/articles/*.md') ?: [];

        foreach ($files as $file) {
            $content = file_get_contents($file);
            $parsed = $this->parseContent($content);
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

    private function getExcerpt(string $content, int $length = 150): string
    {
        $text = preg_replace('/\s+/', ' ', $content);

        if (mb_strlen($text) > $length) {
            $text = mb_substr($text, 0, $length) . '...';
        }

        return $text;
    }

    private function getRandomColor(): string
    {
        $colors = ['#e74c3c', '#3498db', '#9b59b6', '#2ecc71', '#f39c12'];
        return $colors[array_rand($colors)];
    }
}