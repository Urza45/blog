<?php

namespace Lib;

use \Lib\Managers;
use Lib\Session;

abstract class Controller
{
    protected $manager;
    protected $session;
    protected $response = [];
    
    public function __construct()
    {
        $this->manager = new Managers(PDOFactory::getMysqlConnexion());
        $this->session = new Session;
    }
}