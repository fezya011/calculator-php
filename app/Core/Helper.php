<?php
namespace App\Core;

class Helper
{

    public static function truncate($text, $length = 150)
    {
        if (function_exists('mb_strlen')) {
            if (mb_strlen($text, 'UTF-8') > $length) {
                $text = mb_substr($text, 0, $length, 'UTF-8') . '...';
            }
        } else {
            if (strlen($text) > $length) {
                $text = substr($text, 0, $length) . '...';
            }
        }
        return $text;
    }

    public static function getExcerpt($content, $length = 150)
    {
        // Удаляем HTML теги и получаем чистый текст
        $text = strip_tags($content);
        // Удаляем лишние пробелы и переносы строк
        $text = preg_replace('/\s+/', ' ', $text);
        return self::truncate(trim($text), $length);
    }

}