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

    public static function generateSlug($title)
    {
        // Транслитерация для русских символов
        $translit = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya'
        ];

        $title = strtr($title, $translit);
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

    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public static function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}