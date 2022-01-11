<?php

namespace Model;

use \Model\Entity;
use \Lib\Utilities;

class Comments extends Entity
{
    private $content;
    private $date;
    private $disabled;
    private $user_idUser;
    private $post_idPost;

    const INVALID_CONTENT = 1;
    const INVALID_DATE =2;
    const INVALID_DISABLED = 3;
    const INVALID_IDUSER = 4;
    const INVALID_IDPOST = 5;

    public function isVAlid()
    {
        return !(empty($this->content) || empty($this->date)
            || empty($this->disabled) || empty($this->user_idUser)
            || empty($this->post_idPost)
        );
    }

    /** GETTERS */

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the value of disabled
     */ 
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Get the value of user_idUser
     */ 
    public function getUser_idUser()
    {
        return $this->user_idUser;
    }

    /**
     * Get the value of post_idPost
     */ 
    public function getPost_idPost()
    {
        return $this->post_idPost;
    }

    /** SETTERS */

    /**
     * Set the value of content
     *
     * @return  void
     */ 
    public function setContent($content)
    {
        if(empty($content) || !is_string($content)) {
            $this->erreurs[] = self::INVALID_CONTENT;
        } else {
            $this->content = $content;
        }
    }

    /**
     * Set the value of date
     *
     * @return  void
     */ 
    public function setDate($date)
    {
        if (!Utilities::checkDate($date)) {
            $this->erreurs[] = self::INVALID_DATE;
        } else {
            $this->date = $date;
        }
    }

    /**
     * Set the value of disabled
     *
     * @return  void
     */ 
    public function setDisabled($disabled)
    {
        if (!is_bool($disabled)) {
            $this->erreurs[] = self::INVALID_DISABLED;
        } else {
            $this->disabled = $disabled;
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
            $this->erreurs[] = self::INVALID_IDUSER;
        } else {
            $this->user_idUser = $user_idUser;
        }
    }

    /**
     * Set the value of post_idPost
     *
     * @return  void
     */ 
    public function setPost_idPost($post_idPost)
    {
        if (!is_int(intval($post_idPost))) {
            $this->erreurs[] = self::INVALID_IDPOST;
        } else {
            $this->post_idPost = $post_idPost;
        }
    }
}