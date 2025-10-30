<?php
namespace App\Core;

use Parsedown;

class FileManager
{
    public Parsedown $md_parser;

    public function __construct()
    {
        $this->md_parser = new Parsedown();
    }

    public function parse(string $content): void
    {
        echo $this->md_parser->text($content);
    }

    public function parseToHtml(string $content): string
    {
        return $this->md_parser->text($content);
    }

    public function saveArticle(string $slug, string $title, string $content, string $author, ?string $date = null): bool
    {
        $date = $date ?: date('Y-m-d');
        $filePath = ROOT_DIR . '/content/articles/' . $slug . '.md';

        // Создаем директорию, если она не существует
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $frontMatter = "---\n";
        $frontMatter .= "title: " . $title . "\n";
        $frontMatter .= "author: " . $author . "\n";
        $frontMatter .= "date: " . $date . "\n";
        $frontMatter .= "---\n\n";

        $fullContent = $frontMatter . $content;

        return file_put_contents($filePath, $fullContent) !== false;
    }

    public function deleteArticle(string $slug): bool
    {
        $filePath = ROOT_DIR . '/content/articles/' . $slug . '.md';

        if (file_exists($filePath)) {
            return unlink($filePath);
        }

        return false;
    }
}