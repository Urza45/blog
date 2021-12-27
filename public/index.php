<?php

require_once '../vendor/autoload.php';

require '../model/Autoloader.php';
Autoloader::register();

$loader = new \Twig\Loader\FilesystemLoader('../template');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

echo $twig->render('base.html.twig', ['name' => 'Fabien']);