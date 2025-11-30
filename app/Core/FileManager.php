<?php
namespace App\Core;

class FileManager
{
    public function parseToHtml(string $content): string
    {
        return trim($content);
    }
}