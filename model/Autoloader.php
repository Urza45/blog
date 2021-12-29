<?php

namespace Model;

/**
 * Class Autoloader
 * Allows you to search for a class in the Model directory 
 */
class Autoloader{

    static function register() {
            spl_autoload_register([__CLASS__, 'autoload']);
    }

    static function autoload($class_name){
        // var_dump($class_name);
        // $pos = strripos($class_name, '\\' );
        // var_dump($pos);
        // $rest = substr($class_name, 0, $pos);  // retourne "abcde"
        // var_dump($rest);
        // $class = $rest . "\\" . $class_name . ".php";
        require strtolower('../' . $class_name . '.php');
    }

}