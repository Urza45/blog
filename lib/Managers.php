<?php

namespace Lib;

/**
 * Managers
 */
class Managers
{
    protected $dao = null;
    protected $managers = [];
    
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
    
    /**
     * getManagerOf
     *
     * @param  mixed $module
     * @return object
     */
    public function getManagerOf($module)
    {
        if (!is_string($module) || empty($module)) {
            throw new \InvalidArgumentException('Le module spécifié est invalide');
        }

        if (!isset($this->managers[$module])) {
            $manager = '\\Model\\'.$module.'Manager';
            $this->managers[$module] = new $manager($this->dao);
        }

        return $this->managers[$module];
    }
}
