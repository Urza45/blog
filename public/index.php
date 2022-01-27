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

session_start();

use \Lib\Autoloader;
use \Lib\Router;
use \Lib\Request;
use \Twig\Extra\Intl\IntlExtension;

/**
 * Automatic loading of third-party classes 
 */
if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    include_once dirname(__DIR__) . '/vendor/autoload.php';
} else {
    die('Problème d&acute;installation.<br/>Avez-vous exécuter Composer Install ?');
}

/**
 * Automatic loading of project classes 
 * Another method is to use Composer
 */
require dirname(__DIR__) . '/lib/Autoloader.php';
Autoloader::register();

$request = new Request();

/**
 * Twig initiation 
 */
$loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/template');
$twig = new \Twig\Environment(
    $loader, 
    [
        'debug' => true,
        'cache' => false,
    ]
);
/**
 * Add Twig extension for debugging
 */
$twig->addExtension(new \Twig\Extension\DebugExtension());
/**
 * Add Twig extension for format date functions
 */
$twig->addExtension(new IntlExtension());
/**
 * Allow twig to access the session 
 */
if (isset($_SESSION)) {
    $twig->addGlobal('session', $_SESSION);
}
 

/**
 * Call action
 */
$view = Router::getInstance()->run($request);

/**
 * Render
 */
echo $twig->render($view[0], $view[1]);
