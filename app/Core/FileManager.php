<?php
namespace App\Core;

use Parsedown;

class FileManager
{
    public $md_parser;

    public function __construct()
    {
        $this->md_parser = new Parsedown();
    }

    public function parse($content)
    {
        echo $this->md_parser->text($content);
    }

    public function parseToHtml($content)
    {
        return $this->md_parser->text($content);
    }

    public function saveArticle($slug, $title, $content, $author, $date = null)
    {
        $date = $date ?: date('Y-m-d');
        $filePath = ROOT_DIR . '/content/articles/' . $slug . '.md';

        $frontMatter = "---\n";
        $frontMatter .= "title: " . $title . "\n";
        $frontMatter .= "author: " . $author . "\n";
        $frontMatter .= "date: " . $date . "\n";
        $frontMatter .= "---\n\n";

        $fullContent = $frontMatter . $content;

        return file_put_contents($filePath, $fullContent) !== false;
    }

    public function deleteArticle($slug)
    {
        $filePath = ROOT_DIR . '/content/articles/' . $slug . '.md';

        if (file_exists($filePath)) {
            return unlink($filePath);
        }

        return false;
    }
}