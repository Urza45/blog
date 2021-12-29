<?php

use \Model\Autoloader;

const DEFAULT_APP = 'frontend';

if (!isset($_GET['app']) || !file_exists('../controller/'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;

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

/**
 * Twig initiation 
 */
// $loader = new \Twig\Loader\FilesystemLoader('../template');
// $twig = new \Twig\Environment($loader, [
//     'cache' => false,
// ]);

/**
 * 
 */
$app = new \Controller\Frontend\Controller();

echo $app->index();

