<?php
namespace App\Core;

class Helper
{
    public static function sanitize($input)
    {
        if (is_array($input)) {
            return array_map([self::class, 'sanitize'], $input);
        }

        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }


    public static function formatDate($date, $format = 'd.m.Y')
    {
        if (empty($date)) {
            return 'Дата не указана';
        }

        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return self::sanitize($date);
        }

        // Русские названия месяцев
        $monthNames = [
            'January' => 'января', 'February' => 'февраля', 'March' => 'марта',
            'April' => 'апреля', 'May' => 'мая', 'June' => 'июня',
            'July' => 'июля', 'August' => 'августа', 'September' => 'сентября',
            'October' => 'октября', 'November' => 'ноября', 'December' => 'декабря'
        ];

        $formatted = date($format, $timestamp);

        // Заменяем английские названия месяцев на русские
        foreach ($monthNames as $en => $ru) {
            $formatted = str_replace($en, $ru, $formatted);
        }

        return $formatted;
    }

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

    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function getCurrentUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public static function redirect($url, $permanent = false)
    {
        if ($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
        }
        header('Location: ' . $url);
        exit;
    }



}