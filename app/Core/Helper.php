<?php
namespace App\Core;

class Helper
{
    public static function sanitize($input)
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function generateSlug($title)
    {
        $slug = preg_replace('/[^a-z0-9]+/u', '-', strtolower($title));
        $slug = trim($slug, '-');
        return $slug;
    }

    public static function formatDate($date, $format = 'd.m.Y')
    {
        if (empty($date)) {
            return 'Дата не указана';
        }

        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return $date;
        }

        return date($format, $timestamp);
    }

    public static function truncate($text, $length = 150)
    {
        // Используем обычный strlen вместо mb_strlen
        if (strlen($text) > $length) {
            $text = substr($text, 0, $length) . '...';
        }
        return $text;
    }

    public static function getExcerpt($content, $length = 150)
    {
        // Удаляем HTML теги и получаем чистый текст
        $text = strip_tags($content);
        return self::truncate($text, $length);
    }
}