<?php

namespace Model;

use \Model\Entity;
use \Lib\Utilities;

class User extends Entity
{
    private $name;
    private $firstName;
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

    
}