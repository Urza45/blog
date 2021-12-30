<?php

use \Model\Autoloader;
use \Model\Router;
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

var_dump($_GET['url']);
$url = '';
if (isset($_GET['url'])) {
    $url = $_GET['url'];
}

$app = '';
if (isset($_GET['app']) and in_array($_GET['app'], ['Backend', 'Frontend'])) {
    $app = $_GET['app'];
}

$router = new Router($app, $url);
$router->run();

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
// $var = "\controller\\" . $app . "\\controller";
// $controller = new $var();

/**
 * Call action
 */
$vue = $router->run();

/**
 * Render
 */
echo $twig->render($vue[0], $vue[1]);
