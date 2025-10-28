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

        // Для PHP страниц просто включаем файл и получаем буферизованный вывод
        ob_start();
        include $file;
        $content = ob_get_clean();

        // Парсим заголовок из первого h1
        preg_match('/<h1[^>]*>(.*?)<\/h1>/', $content, $matches);
        $title = $matches[1] ?? ucfirst($name);

        return [
            'title' => $title,
            'content' => $content
        ];
    }

    public function getArticle($name)
    {
        $file = ROOT_DIR."/content/articles/{$name}.md";

        if (!file_exists($file)) {
            return null;
        }

        $content = file_get_contents($file);
        $parsed = $this->parseMarkdownWithFrontMatter($content);

        return [
            'title' => $parsed['meta']['title'] ?? 'Статья',
            'content' => $parsed['content'],
            'meta' => $parsed['meta'],
            'excerpt' => $this->helper::getExcerpt($parsed['content'])
        ];
    }

    public function getArticles($limit = null)
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

        if ($limit) {
            $files = array_slice($files, 0, $limit);
        }

        foreach ($files as $file) {
            $content = file_get_contents($file);
            $parsed = $this->parseMarkdownWithFrontMatter($content);
            $parsed['meta']['slug'] = pathinfo($file, PATHINFO_FILENAME);

            $articles[] = [
                'title' => $parsed['meta']['title'] ?? 'Статья',
                'content' => $parsed['content'],
                'meta' => $parsed['meta'],
                'excerpt' => $this->helper::getExcerpt($parsed['content'])
            ];
        }

        return $articles;
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

        // Если нет фронт-матера, парсим весь контент как Markdown
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

                // Обработка дат
                if ($key === 'date' && strtotime($value)) {
                    $value = date('Y-m-d', strtotime($value));
                }

                $data[$key] = $value;
            }
        }

        return $data;
    }
}