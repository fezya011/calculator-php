<?php
namespace App\Models;

class Page
{
    private $title;
    private $content;
    private $meta;

    public function __construct($title = '', $content = '', $meta = [])
    {
        $this->title = $title;
        $this->content = $content;
        $this->meta = $meta;
    }


    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getMeta() {
        return $this->meta;
    }

    public function setMeta($meta) {
        $this->meta = $meta;
    }

    public function render() {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'meta' => $this->meta
        ];
    }


    public function getSin()
    {
        return sin(deg2rad(45));
    }
}