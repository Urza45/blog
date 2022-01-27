<?php

namespace Lib;

use \Lib\FormValidator;

class Request
{
    private $url;
    private $method;
    private $query;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->query = $_SERVER['QUERY_STRING'];
    }

    public function isGet() {
        return ($this->method == 'GET') ? true : false;
    }

    public function isPost() {
        return ($this->method == 'POST') ? true : false;
    }

    public function getParams() {
        
        if ($this->isPost()) {
            $params = [];
            foreach ($_POST as $key => $value) {
                $params[$key] = FormValidator::purify($value);
            }
            return $params;
        }
        if ($this->isGet()) {
            $params = [];
            foreach ($_GET as $key => $value) {
                $params[$key] = FormValidator::purify($value);
            }
            return $params;
        }
        return array();
    }

    public function getMethod() {
        return $this->method;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getQuery() {
        return $this->query;
    }

    
}