<?php

namespace Model;

use \Model\Entity;
use \Lib\Utilities;

class User extends Entity
{
    private $name;
    private $firstName;
    private $pseudo;
    private $email;
    private $phone;
    private $portable;
    private $password;
    private $salt;
    private $statusConnected;
    private $activeUser;
    private $validationKey;
    private $activatedUser;
    private $dateCreate;
    private $typeUser_idTypeUSer;

    const INVALID_NAME = 1;
    const INVALID_FIRSTNAME = 2;
    const INVALID_EMAIL = 3;
    const INVALID_PHONE = 4;
    const INVALID_PORTABLE = 5;
    const INVALID_PASWWORD = 6;
    const INVALID_SALT = 7;
    const INVALID_STATUS_CONNECTED = 8;
    const INVALID_ACTIVE_USER = 9;
    const INVALID_KEY = 10;
    const INVALID_ACTIVATED_USER = 11;
    const INVALID_DATE = 12;
    const INVALID_IDUSER = 13;

    public function isVAlid()
    {
        return !(empty($this->name));
    }
    
    /** GETTERS */



    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the value of portable
     */ 
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of salt
     */ 
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Get the value of statusConnected
     */ 
    public function getStatusConnected()
    {
        return $this->statusConnected;
    }

    /**
     * Get the value of activeUser
     */ 
    public function getActiveUser()
    {
        return $this->activeUser;
    }

    /**
     * Get the value of validationKey
     */ 
    public function getValidationKey()
    {
        return $this->validationKey;
    }

    /**
     * Get the value of activatedUser
     */ 
    public function getActivatedUser()
    {
        return $this->activatedUser;
    }

    /**
     * Get the value of dateCreate
     */ 
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Get the value of typeUser_idTypeUSer
     */ 
    public function getTypeUser_idTypeUSer()
    {
        return $this->typeUser_idTypeUSer;
    }

    /**
     * Get the value of pseudo
     */ 
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /** SETTERS */

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Set the value of pseudo
     *
     * @return  self
     */ 
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Set the value of portable
     *
     * @return  self
     */ 
    public function setPortable($portable)
    {
        $this->portable = $portable;

        return $this;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set the value of salt
     *
     * @return  self
     */ 
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set the value of statusConnected
     *
     * @return  self
     */ 
    public function setStatusConnected($statusConnected)
    {
        $this->statusConnected = $statusConnected;

        return $this;
    }

    /**
     * Set the value of activeUser
     *
     * @return  self
     */ 
    public function setActiveUser($activeUser)
    {
        $this->activeUser = $activeUser;

        return $this;
    }
    

    /**
     * Set the value of validationKey
     *
     * @return  self
     */ 
    public function setValidationKey($validationKey)
    {
        $this->validationKey = $validationKey;

        return $this;
    }

    /**
     * Set the value of activatedUser
     *
     * @return  self
     */ 
    public function setActivatedUser($activatedUser)
    {
        $this->activatedUser = $activatedUser;

        return $this;
    }

    /**
     * Set the value of dateCreate
     *
     * @return  self
     */ 
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Set the value of typeUser_idTypeUSer
     *
     * @return  self
     */ 
    public function setTypeUser_idTypeUSer($typeUser_idTypeUSer)
    {
        $this->typeUser_idTypeUSer = $typeUser_idTypeUSer;

        return $this;
    }


    
}