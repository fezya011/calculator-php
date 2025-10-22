<?php

namespace App\Core;

class Helper
{
    public static function dd($variable)
    {
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
        exit();
    }

    public static function dump($variable)
    {
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
    }

}