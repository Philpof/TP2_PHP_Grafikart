<?php

use App\Helpers\Text;
use App\Model\Post;

$title = 'Mon Blog';
$nbrArtPage = 12;

// Connexion à la BDD
$pdo = new PDO('mysql:dbname=tutoblog;host=127.0.0.1', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$page = $_GET['page'] ?? 1; // On récupère le numéro de la page dans l'url. Si la valeur n'existe pas alors on mettra 1

if (!filter_var($page, FILTER_VALIDATE_INT)) {
    throw new Exception('Numéro de page invalide');
}

if ($page ==='1') {
    header('Location: ' . $router->url('home'));
    http_response_code(301); // Pour indiquer la redirection permanente vers Home
    exit();
}

$currentPage = (int)$page;

if ($currentPage <= 0) {
    throw new Exception('Numéro de page invalide');
}

$count = (int)$pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0]; // Requête, fetch sous forme de tableau numérique dans lequel on ne récupère que la 1ère colonne
$pages = ceil($count / $nbrArtPage);
if ($currentPage > $pages) {
    throw new Exception('Cette page n\'existe pas');
}
$offset = $nbrArtPage * ($currentPage -1);
$query = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT $nbrArtPage OFFSET $offset");
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class); // On a utilsé FETCH_OBJ avnat de créer le classe Post
?>

<h1>Mon blog</h1>

<div class="row">
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <?php require 'card.php' ?>
    </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
        <?php if ($currentPage > 1): ?>
            <?php
            $link = $router->url('home');
            if ($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
            ?>
            <a href="<?= $link ?>" class="btn btn-primary">&#12296; Page précédente</a>
        <?php endif ?>
        <?php if ($currentPage < $pages): ?>
            <a href="<?= $router->url('home') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ml-auto">Page suivante &#12297;</a>
        <?php endif ?>
</div>