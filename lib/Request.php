<?php

namespace Lib;

class Request
{
    private $url;
    private $method;
    private $query;

    

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
        //var_dump($this->url);
        $this->query = $_SERVER['QUERY_STRING'];
        //var_dump($this->query);
    }

    public function isGet() {
        return ($this->method == 'GET') ? true : false;
    }

    public function isPost() {
        return ($this->method == 'POST') ? true : false;
    }

    public function getParams() {
        if ($this->isPost()) return $_POST;
        if ($this->isGet()) return $_GET;
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