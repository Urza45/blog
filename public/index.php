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
 * @version  GIT: 2.33.1
 * @access   public
 * @link     https://www.urza-web.fr
 */

use Lib\Autoloader;
use Lib\Router;
use Lib\Request;
use Lib\Session;
use Lib\Config;
use Lib\MyTwig;

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
if (is_file($config->get('directory') . '/vendor/autoload.php')) {
    include_once $config->get('directory') . '/vendor/autoload.php';
} else {
    die('Problème d&acute;installation.<br/>Avez-vous exécuté Composer Install ?');
}

$session = new Session();
$session->start();

$request = new Request();

/**
 * Call action
 */
$view = Router::getInstance()->run($request);

/**
 * Render
 */
$twig = new MyTwig($session);
$twig->getRender($view);
