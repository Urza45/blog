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

    public function isValid()
    {
        // var_dump(empty($this->content));
        // var_dump(empty($this->date));
        // var_dump($this->disabled);
        // var_dump(!in_array($this->disabled, ['0', '1']));
        // var_dump(empty($this->user_idUser));
        // var_dump(empty($this->post_idPost));
        return !( (empty($this->content) || empty($this->date)
            || !in_array($this->disabled, ['0', '1']) || empty($this->user_idUser)
            || empty($this->post_idPost))
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
            $this->errors[] = self::INVALID_CONTENT;
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
            $this->errors[] = self::INVALID_DATE;
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
        if (!(in_array($disabled, ['0', '1'])  )) {
            $this->errors[] = self::INVALID_DISABLED;
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
            $this->errors[] = self::INVALID_IDUSER;
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
            $this->errors[] = self::INVALID_IDPOST;
        } else {
            $this->post_idPost = $post_idPost;
        }
    }
}