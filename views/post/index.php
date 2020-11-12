<?php

use App\Connection;
use App\URL;
use App\Model\Post;
use App\Helpers\Text;

$title = 'Mon Blog';
$nbrArtPage = 12;

// Connexion à la BDD
$pdo = Connection::getPDO();

$currentPage = URL::getPositiveInt('page', 1); // Récupère un entier depuis le paramètre 'page' dans l'url et si la paramètre n'est pas défini alors on met 1

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