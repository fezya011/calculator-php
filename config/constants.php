<?php
// Используйте DIRECTORY_SEPARATOR для кроссплатформенности
define('ROOT_DIR', dirname(__DIR__));
define('CONTENT_PATH', ROOT_DIR . '/content');
define('VIEWS_PATH', ROOT_DIR . '/content/templates');
define('ASSETS_PATH', ROOT_DIR . '/assets');
define('UPLOAD_PATH', ROOT_DIR . '/assets/uploads');

// Или более простой вариант - используйте обычные слеши (они работают в Windows)
/*
define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT']);
define('CONTENT_PATH', ROOT_DIR . '/content');
define('VIEWS_PATH', ROOT_DIR . '/content/templates');
define('ASSETS_PATH', ROOT_DIR . '/assets');
define('UPLOAD_PATH', ROOT_DIR . '/assets/uploads');
*/