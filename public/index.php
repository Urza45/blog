<?php

use \Model\Autoloader;

/**
 * Automatic loading of third-party classes 
 */
if (file_exists('../vendor/autoload.php')) {
    require_once '../vendor/autoload.php';
} else {
    die ('Problème d&acute;installation.<br/>Avez-vous charger les librairies tierces nécessaires ?');
}

/**
 * Automatic loading of project classes 
 */
require '../model/Autoloader.php';
Autoloader::register();

$url = '';
if (isset($_GET['url'])) {
    $url = $_GET['url'];
}

$app = '';
if (isset($_GET['app'])) {
    $app = $_GET['app'];
}

/**
 * Twig initiation 
 */
$loader = new \Twig\Loader\FilesystemLoader('../template');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

/**
 * Controller initiation 
 */
$var = "\controller\\" . $app . "\\controller";
$controller = new $var();

/**
 * Call action
 */
$vue = $controller->index();

/**
 * Render
 */
print $twig->render($vue[0], $vue[1]);
