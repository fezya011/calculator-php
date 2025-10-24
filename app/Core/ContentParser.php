<?php
namespace App\Core;

class ContentParser
{
    public $md_parser;

    public function __construct()
    {
        $this->md_parser = new FileManager();
    }

    public function getPage($name)
    {
        $file = ROOT_DIR."/content/pages/{$name}.php";

        if (!file_exists($file)) {
            return null;
        }

        $content = file_get_contents($file);
        $lines = explode("\n", $content);

        $title = trim($lines[0], "# ");
        $body = implode("\n", array_slice($lines, 1));

        return [
            'title' => $title,
        ];
    }

    public function getArticle($name)
    {
        $file = ROOT_DIR."/content/articles/{$name}.md";

        if (!file_exists($file)) {
            return null;
        }

        $content = file_get_contents($file);
        $lines = explode("\n", $content);

        $title = trim($lines[0], "# ");
        $body = implode("\n", array_slice($lines, 1));

        return [
            'title' => $title,
            'content' => $this->md_parser->parse($body)
        ];
    }

}