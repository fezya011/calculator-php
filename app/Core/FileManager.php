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

}