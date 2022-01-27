<?php

namespace Model;

use \Model\Entity;
use \Lib\Utilities;

class Post extends Entity
{
    private $title;
    private $chapo;
    private $content;
    private $dateCreate;
    private $user_idUser;

    const INVALID_TITLE = 1;
    const INVALID_CHAPO = 2;
    const INVALID_CONTENT = 3;
    const INVALID_DATE = 4;
    const INVALID_IDUSER = 5;

    public function isValid()
    {
        return !(empty($this->title) || empty($this->chapo)
            || empty($this->content) || empty($this->dateCreate)
            || empty($this->user_idUser)
        );
    }

    /** GETTERS */

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the value of chapo
     */ 
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the value of dateCreate
     */ 
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Get the value of User_idUser
     */ 
    public function getUser_idUser()
    {
        return $this->user_idUser;
    }

    /** SETTERS */

    /**
     * Set the value of title
     *
     * @return  void
     */ 
    public function setTitle($title)
    {
        
        if(empty($title) || !is_string($title)) {
            $this->errors[] = self::INVALID_TITLE;
        } else {
            $this->title = $title;
        }
    }

    /**
     * Set the value of chapo
     *
     * @return  void
     */ 
    public function setChapo($chapo)
    {
        if(empty($chapo) || !is_string($chapo)) {
            $this->errors[] = self::INVALID_CHAPO;
        } else {
            $this->chapo = $chapo;
        }
    }

    /**
     * Set the value of content
     *
     * @return  void
     */ 
    public function setContent($content)
    {
        if(empty($content)) {
            $this->errors[] = self::INVALID_CONTENT;
        } else {
            $this->content = $content;
        }
    }

    /**
     * Set the value of dateCreate
     *
     * @return  void
     */ 
    public function setDateCreate($dateCreate)
    {
        if (!Utilities::checkDate($dateCreate)) {
            $this->errors[] = self::INVALID_DATE;
        } else {
            $this->dateCreate = $dateCreate;
        }
    }

    /**
     * Set the value of user_idUser
     *
     * @return  void
     */ 
    public function setUser_idUser($user_idUser)
    {
        if (!is_int(intval($user_idUser))) {
            $this->errors[] = self::INVALID_IDUSER;
        } else {
            $this->user_idUser = $user_idUser;
        }
    }
}