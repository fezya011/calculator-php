<?php
namespace App\Core;

class Helper
{
    public function getExcerpt(string $content, int $length = 150): string
    {
        $text = strip_tags($content);
        $text = preg_replace('/\s+/', ' ', $text);

        if (mb_strlen($text) > $length) {
            $text = mb_substr($text, 0, $length) . '...';
        }

        return $text;
    }
}