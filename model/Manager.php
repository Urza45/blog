<?php

namespace Model;

/**
 * Manager
 */
abstract class Manager
{
    protected $dao;
      
    /**
     * __construct
     *
     * @param  mixed $dao
     * @return void
     */
    public function __construct($dao)
    {
        $this->dao = $dao;
    }
}