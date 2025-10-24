<?php

namespace App\Core;

use Parsedown;

require_once ROOT_DIR . "/vendor/erusev/parsedown/Parsedown.php";

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

}