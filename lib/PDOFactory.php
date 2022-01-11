<?php

namespace Lib;

use \Lib\Config;

class PDOFactory
{
  public static function getMysqlConnexion()
  {
    $config = Config::getInstance();
    // Dev
    $db = new \PDO('mysql:host=' . $config->get('db_host') . ';dbname=' .  $config->get('db_name'), $config->get('db_user'), $config->get('db_pass'));
    // Test
    // Prod
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
    return $db;
  }
}