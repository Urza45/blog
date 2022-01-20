<?php
declare(strict_types=1);

namespace Lib;

/**
 * Class Autoloader
 * Allows you to search for a class in the Model directory 
 */
class Autoloader {

    static function register() : void
    {
            spl_autoload_register([__CLASS__, 'autoload']);
    }

    static function autoload($class_name) : void
    {
        $class = dirname(__DIR__) . '/' . lcfirst(str_replace('\\', DIRECTORY_SEPARATOR, $class_name)) . '.php';
        if(file_exists($class))
        {
            require_once($class);
        } else {
            echo 'ERROR: '. $class . '<br/>';
        }
    }

}