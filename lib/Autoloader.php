<?php
declare(strict_types=1);

namespace Lib;

/**
 * Class Autoloader
 * Allows you to search for a class in the Model directory 
 */
class Autoloader {

    /**
     * Replace with the correct path 
     */
    const DIRECTORY = 'D:\WAMP\www\blog';
    
    static function register() : void
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    static function autoload($class_name) : void
    {
        $class = self::DIRECTORY . DIRECTORY_SEPARATOR . lcfirst(str_replace('\\', DIRECTORY_SEPARATOR, $class_name)) . '.php';
        if ( (require_once($class)) == false ) {
            print_r('ERROR: '. $class . '<br/>');
        } 
    }

}