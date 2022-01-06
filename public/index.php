<?php
/**
 * Blog personnel
 * Main file
 * php version 7.4.9
 * 
 * @category Blog
 * @package  MyBlog
 * @author   Serge Pillay <serge.pillay@orange.fr>
 * @license  Free 
 * @version  GIT: <git_id>
 * @access   public
 * @link     https://www.urza-web.fr
 */

use \Model\Autoloader;
use \Model\Router;
use \Model\Request;

/**
 * Automatic loading of third-party classes 
 */
if (file_exists('../vendor/autoload.php')) {
    include_once '../vendor/autoload.php';
} else {
    die('Problème d&acute;installation.<br/>Avez-vous exécuter Composer Install ?');
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
$twig = new \Twig\Environment(
    $loader, 
    [
        'cache' => false,
    ]
);

/**
 * Call action
 */
$vue = Router::run($request);

/**
 * Render
 */
echo $twig->render($vue[0], $vue[1]);
