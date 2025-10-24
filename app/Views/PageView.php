<?php

namespace App\Views;

class PageView
{
    public function render($template, $data = [])
    {
        extract($data);

        include ROOT_DIR .'/content/templates/header.php';
        include ROOT_DIR .'/content/templates/sidebar.php';

        if ($template === 'home' || $template === 'more' || $template === 'calculator' || $template === 'about') {

            include ROOT_DIR . "/content/pages/{$template}.php";
        } else {

            echo $content;
        }

        include ROOT_DIR . '/content/templates/footer.php';
    }

    public function show404()
    {
        include ROOT_DIR .'/content/templates/header.php';
        include ROOT_DIR .'/content/templates/sidebar.php';
        http_response_code(404);
        include ROOT_DIR . '/content/templates/404.php';
        include ROOT_DIR . '/content/templates/footer.php';
    }
}