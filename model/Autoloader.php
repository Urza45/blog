<?php
declare(strict_types=1);

namespace Model;

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
        $class = strtolower(dirname(__DIR__) . '/' . $class_name . '.php');
        require_once $class;
    }

}