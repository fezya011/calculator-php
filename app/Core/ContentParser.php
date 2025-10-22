<?php
namespace App\Core;

class ContentParser
{
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
            'content' => $this->simpleMarkdown($body)
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
            'content' => $this->simpleMarkdown($body)
        ];
    }

    private function simpleMarkdown($text)
    {
        $text = preg_replace('/### (.*)/', '<h3>$1</h3>', $text);
        $text = preg_replace('/## (.*)/', '<h2>$1</h2>', $text);
        $text = preg_replace('/# (.*)/', '<h1>$1</h1>', $text);
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
        $text = '<p>' . preg_replace('/\n\n/', '</p><p>', $text) . '</p>';
        return $text;
    }
}