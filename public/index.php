<?php
require '../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

// La partie ci-dessous concernant Whoops, sera à commenter lors d ela mise en prod de l'appli
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new App\Router(dirname(__DIR__) . '/views');
$router
    ->get('/', 'post/index', 'poil')
    ->get('/blog', 'post/index', 'blog')
    ->get('/blog/category', 'category/show', 'category')
    ->run();