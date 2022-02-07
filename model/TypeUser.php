<?php

namespace Model;

use \Model\Entity;

/**
 * TypeUser
 */
class TypeUser extends Entity
{
    private $label;

    const INVALID_LABEL = 1;
    
    /**
     * isVAlid
     *
     * @return void
     */
    public function isVAlid()
    {
        return !(empty($this->label));
    }

    /** GETTERS */

    /**
     * Get the value of label
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /** SETTERS */

    /**
     * Set the value of label
     *
     * @return  void
     */ 
    public function setLabel($label)
    {
        if(empty($title) || !is_string($title)) {
            $this->errors[] = self::INVALID_LABEL;
        } else {
            $this->label = $label;
        }
    }
}