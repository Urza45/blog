<?php

namespace Lib;

use \Lib\Config;

/**
 * PDOFactory
 */
class PDOFactory
{   
   /**
    * getMysqlConnexion
    *
    * @return void
    */
   public static function getMysqlConnexion()
   {
        $config = Config::getInstance();
        $database = new \PDO('mysql:host=' . $config->get('db_host') . ';dbname=' . $config->get('db_name'), $config->get('db_user'), $config->get('db_pass'));
        $database->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
        return $database;
    }
}