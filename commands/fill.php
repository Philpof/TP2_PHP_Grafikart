<?php
require dirname(__DIR__) . '/vendor/autoload.php';

// Onutilise Faker pour générer des données aléatoires
$faker = Faker\Factory::create('fr_FR');

// Connexion à la BDD
$pdo = Connection::getPDO();

// On vide complètement la BDD
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

// On enregistre les ids des contenus créés
$posts = [];
$categories = [];

// Création des posts
for ($i = 0; $i < 50; $i++) {
    $pdo->exec("INSERT INTO post SET name='{$faker->sentence()}', slug='{$faker->slug}', created_at='{$faker->date} {$faker->time}', content='{$faker->paragraphs(rand(3,15), true)}'");
    $posts[] = $pdo->lastInsertId();
}

// Création des catégories
for ($i = 0; $i < 5; $i++) {
    $pdo->exec("INSERT INTO category SET name='{$faker->sentence(3)}', slug='{$faker->slug}'");
    $categories[] = $pdo->lastInsertId();
}

// On associe aléatoirement des articles à des catégories
foreach($posts as $post) {
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach ($randomCategories as $category) {
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$category");
    }
}

// Création des Users
$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user SET user_name='admin', password='$password'");