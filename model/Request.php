<?php

namespace Model;

class Request
{
    private $url;
    private $method;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['QUERY_STRING'];
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
}