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
    private $post;
    private $get;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->define_global();
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
            foreach ($this->post as $key => $value) {
                $params[$key] = FormValidator::purify($value);
            }
            return $params;
        }
        if ($this->isGet()) {
            $params = [];
            foreach ($this->get as $key => $value) {
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

    private function define_global()
    {
        $this->method = (isset($_SERVER['REQUEST_METHOD'])) ? $_SERVER['REQUEST_METHOD'] : null;
        $this->url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : null;
        $this->query = (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : null;
        $this->post = (isset($_POST)) ? $_POST : null;
        $this->get = (isset($_GET)) ? $_GET : null;
    }
}