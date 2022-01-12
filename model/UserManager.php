<?php

namespace Model;

use \Model\Manager;
use \Model\User;

class UserManager extends Manager
{    
    /**
     * getListUser
     *
     * @param  int $number
     * @return array of User
     */
    public function getListUser(int $number = null)
    {
        $sql = 'SELECT id, name, firstName, email, phone, portable,'
        .' password, salt, statusConnected, activeUser, validationKey'
        .' validationKey, activatedUser, dateCreate, typeUser_idTypeUSer'
        .' FROM user ORDER BY name, firstName DESC';

        if (isset($number)) {
            $sql .= ' limit ' . $number;
        }

        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\User');

        $listUser = $requete->fetchAll();
        
        return $listUser;
    }
    
    /**
     * getUnique
     *
     * @param  mixed $id
     * @return instance of User
     */
    public function getUnique(int $id)
    {
        $sql = 'SELECT id, name, firstName, email, phone, portable,'
        .' password, salt, statusConnected, activeUser, validationKey'
        .' validationKey, activatedUser, dateCreate, typeUser_idTypeUSer'
        .' FROM user WHERE id = :id';
        
        $requete = $this->dao->prepare($sql);
        $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $requete->execute();
    
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\User');
    
        if ($user = $requete->fetch())
        {
            return $user;
        }
    
        return null;
    }
    
    /**
     * count
     *
     * @return int
     */
    public function count()
    {
        return $this->dao->query('SELECT COUNT(*) FROM User')->fetchColumn();
    }
    
    /**
     * save
     *
     * @param  mixed $user
     * @return void
     */
    public function save(User $user)
    {
        if ($user->isValid())
        {
            $user->isNew() ? $this->add($user) : $this->modify($user);
        }
        else
        {
            throw new \RuntimeException('Votre User doit être validé pour être enregistré.');
        }
    }
    
    /**
     * add
     *
     * @param  mixed $user
     * @return void
     */
    private function add(User $user)
    {
        $sql = 'INSERT INTO user SET '
        . 'name = :name,'
        . 'firstName = :firstName, '
        . 'email = :email, '
        . 'phone = phone, '
        . 'portable = :portable'
        . 'password = :password'
        . 'salt = :salt'
        . 'statusConnected = :statusConnected'
        . 'activeUser = :activeUser'
        . 'validationKey = :validationKey'
        . 'activatedUser = :activatedUser'
        . 'dateCreate = :dateCreate'
        . 'TypeUser_idTypeUser = :TypeUser_idTypeUser';
        $requete = $this->dao->prepare($sql);

        $requete->bindValue(':name', $user->getName());
        $requete->bindValue(':firstName', $user->getFirstName());
        $requete->bindValue(':email', $user->getEmail());
        $requete->bindValue(':phone', $user->getPhone());
        $requete->bindValue(':portable', $user->getPortable());
        $requete->bindValue(':password', $user->getPassword());
        $requete->bindValue(':salt', $user->getSalt());
        $requete->bindValue(':statusConnected', $user->getStatusConnected());
        $requete->bindValue(':activeUser', $user->getActiveUser());
        $requete->bindValue(':validationKey', $user->getValidationKey());
        $requete->bindValue(':activatedUser', $user->getActivatedUser());
        $requete->bindValue(':dateCreate', $user->getDateCreate());
        $requete->bindValue(':TypeUser_idTypeUser', $user->getTypeUser_idTypeUser());
    
        $requete->execute();
    }
    
    /**
     * modify
     *
     * @param  mixed $user
     * @return void
     */
    private function modify(User $user)
    {
        $sql = 'UPDATE user SET '
        . 'name = :name,'
        . 'firstName = :firstName, '
        . 'email = :email, '
        . 'phone = phone, '
        . 'portable = :portable'
        . 'password = :password'
        . 'salt = :salt'
        . 'statusConnected = :statusConnected'
        . 'activeUser = :activeUser'
        . 'validationKey = :validationKey'
        . 'activatedUser = :activatedUser'
        . 'dateCreate = :dateCreate'
        . 'TypeUser_idTypeUser = :TypeUser_idTypeUser'
        . 'WHERE id = :id';
        $requete = $this->dao->prepare($sql);

        $requete->bindValue(':name', $user->getName());
        $requete->bindValue(':firstName', $user->getFirstName());
        $requete->bindValue(':email', $user->getEmail());
        $requete->bindValue(':phone', $user->getPhone());
        $requete->bindValue(':portable', $user->getPortable());
        $requete->bindValue(':password', $user->getPassword());
        $requete->bindValue(':salt', $user->getSalt());
        $requete->bindValue(':statusConnected', $user->getStatusConnected());
        $requete->bindValue(':activeUser', $user->getActiveUser());
        $requete->bindValue(':validationKey', $user->getValidationKey());
        $requete->bindValue(':activatedUser', $user->getActivatedUser());
        $requete->bindValue(':dateCreate', $user->getDateCreate());
        $requete->bindValue(':TypeUser_idTypeUser', $user->getTypeUser_idTypeUser());
        $requete->bindValue(':id', $user->getId(), \PDO::PARAM_INT);
    }
    
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete(int $id)
    {
        $this->dao->exec('DELETE FROM user WHERE id = '.(int) $id);
        $this->dao->exec('DELETE FROM comments WHERE User_idUser = '.(int) $id);
    }

}