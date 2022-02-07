<?php

namespace Lib;

use \Lib\FormValidator;

/**
 * Request
 */
class Request
{
    private $url;
    private $method;
    private $query;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->query = $_SERVER['QUERY_STRING'];
    }
    
    /**
     * isGet
     *
     * @return void
     */
    public function isGet() {
        return ($this->method == 'GET') ? true : false;
    }
    
    /**
     * isPost
     *
     * @return void
     */
    public function isPost() {
        return ($this->method == 'POST') ? true : false;
    }
    
    /**
     * getParams
     *
     * @return void
     */
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
    
    /**
     * getMethod
     *
     * @return void
     */
    public function getMethod() {
        return $this->method;
    }
    
    /**
     * getUrl
     *
     * @return void
     */
    public function getUrl() {
        return $this->url;
    }
    
    /**
     * getQuery
     *
     * @return void
     */
    public function getQuery() {
        return $this->query;
    }
}