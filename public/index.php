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

//session_start();

use \Lib\Autoloader;
use \Lib\Router;
use \Lib\Request;
use \Lib\Session;
use \Lib\Config;
use \Twig\Extra\Intl\IntlExtension;

/**
 * Automatic loading of project classes 
 * Another method is to use Composer
 */
require '../lib/Autoloader.php';
Autoloader::register();

$config = Config::getInstance();

/**
 * Automatic loading of third-party classes 
 */
if (file_exists($config->get('directory') . '/vendor/autoload.php')) {
    include_once $config->get('directory') . '/vendor/autoload.php';
} else {
    die('Problème d&acute;installation.<br/>Avez-vous exécuté Composer Install ?');
}

$session = new Session();
$session->start();

$request = new Request();

/**
 * Twig initiation 
 */
$loader = new \Twig\Loader\FilesystemLoader($config->get('directory') . '/template');
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
if ($session->existSession()) {
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
