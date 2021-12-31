<?php

use \Model\Autoloader;
use \Model\Router;
use \Model\Request;

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
 * Another method is to use Composer
 */
require '../model/Autoloader.php';
Autoloader::register();

$request = new \Model\Request();

/**
 * Twig initiation 
 */
$loader = new \Twig\Loader\FilesystemLoader('../template');
$twig = new \Twig\Environment($loader, [
	'cache' => false,
]);

/**
 * Call action
 */
$vue = Router::run($request);

/**
 * Render
 */
echo $twig->render($vue[0], $vue[1]);
