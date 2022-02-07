<?php

namespace Lib;

use \Lib\Managers;
use \Lib\Session;

/**
 * Controller
 */
abstract class Controller
{
    protected $manager;
    protected $session;
    protected $response = [];
    protected $security = false;
    
    public function __construct()
    {
        $this->manager = new Managers(PDOFactory::getMysqlConnexion());
        $this->session = new Session;
    }
}