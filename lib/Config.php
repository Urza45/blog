<?php
declare(strict_types=1);

namespace Lib;

/**
 * Class Autoloader
 * Allows you to search for a class in the Model directory 
 */
class Config {

    private $settings = [];
    private static $_instance; // L'attribut qui stockera l'instance unique

    /**
    * La méthode statique qui permet d'instancier ou de récupérer l'instance unique
    **/
    public static function getInstance($file)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Config($file);
        }
        return self::$_instance;
    }

    /**
    * Le constrcuteur avec sa logique est privé pour émpêcher l'instanciation en dehors de la classe
    **/
    private function __construct()
    {
        $this->settings = require dirname(__DIR__) . '/config/config.php';
    }

    /**
    *  Permet d'obtenir la valeur de la configuration
    *  @param $key string clef à récupérer
    *  @return mixed
    **/
    public function get($key)
    {
        if (!isset($this->settings[$key])) {
            return null;
        }
        return $this->settings[$key];
    }

}