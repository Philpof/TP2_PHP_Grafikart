<?php
require '../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));

// La partie ci-dessous concernant Whoops, sera à commenter lors de la mise en prod de l'appli
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if (isset($_GET['page']) && $_GET['page'] === '1') {
    // Réécrire l'url sans le paramètre ?page
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    unset($get['page']);
    $query = http_build_query($get);

    $uri = $uri . (empty($query) ? '' : '?' . $query); //Idem que : if (!empty($query)) { $uri = $uri . '?' . $query; }
    
    http_response_code(301);
    header('Location: ' . $url);
    exit();
}

$router = new App\Router(dirname(__DIR__) . '/views');
$router
    ->get('/', 'post/index', 'home')
    ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
    ->get('/blog/category', 'category/show', 'category')
    ->run();