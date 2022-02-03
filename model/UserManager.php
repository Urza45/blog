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
        $sql = 'SELECT id, name, firstName, pseudo, email, phone, portable,'
        .' password, salt, statusConnected, activeUser, validationKey'
        .' validationKey, activatedUser, dateCreate, typeUser_idTypeUSer, askPromotion' 
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
        $sql = 'SELECT id, name, firstName, pseudo, email, phone, portable,'
        .' password, salt, statusConnected, activeUser, validationKey'
        .' validationKey, activatedUser, dateCreate, typeUser_idTypeUSer, askPromotion'
        .' FROM user WHERE id = :id';
        
        $requete = $this->dao->prepare($sql);
        $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $requete->execute();
    
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\User');
    
        if ($user = $requete->fetch())
        {
            return $user;
        }
    
        return null;
    }

    public function getUniqueByPseudo(string $pseudo)
    {
        $sql = 'SELECT id, name, firstName, pseudo, email, phone, portable,'
        .' password, salt, statusConnected, activeUser, validationKey'
        .' validationKey, activatedUser, dateCreate, typeUser_idTypeUSer, askpromotion'
        .' FROM user WHERE pseudo = :pseudo';
        
        $requete = $this->dao->prepare($sql);
        $requete->bindValue(':pseudo', $pseudo);
        $requete->execute();
    
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\User');
    
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
            if ($user->isNew()) {
                return $this->add($user);
            } else {
                return $this->modify($user);
            }
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
        . 'pseudo = :pseudo, '
        . 'email = :email, '
        . 'phone = :phone, '
        . 'portable = :portable, '
        . 'password = :password, '
        . 'salt = :salt, '
        . 'statusConnected = :statusConnected, '
        . 'activeUser = :activeUser, '
        . 'validationKey = :validationKey, '
        . 'activatedUser = :activatedUser, '
        . 'dateCreate = :dateCreate, '
        . 'TypeUser_idTypeUser = :TypeUser_idTypeUser';
        $requete = $this->dao->prepare($sql);

        $requete->bindValue(':name', $user->getName());
        $requete->bindValue(':firstName', $user->getFirstName());
        $requete->bindValue(':pseudo', $user->getPseudo());
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
        $row_count = $requete->rowCount();
        return $row_count;
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
        . 'name = :name, '
        . 'firstName = :firstName, '
        . 'pseudo = :pseudo, '
        . 'email = :email, '
        . 'phone = :phone, '
        . 'portable = :portable, '
        . 'password = :password, '
        . 'salt = :salt, '
        . 'statusConnected = :statusConnected, '
        . 'activeUser = :activeUser, '
        . 'validationKey = :validationKey, '
        . 'activatedUser = :activatedUser, '
        . 'dateCreate = :dateCreate, '
        . 'TypeUser_idTypeUser = :TypeUser_idTypeUser '
        . 'WHERE id = :id';

        $requete = $this->dao->prepare($sql);

        $requete->bindValue(':name', $user->getName());
        $requete->bindValue(':firstName', $user->getFirstName());
        $requete->bindValue(':pseudo', $user->getPseudo());
        $requete->bindValue(':email', $user->getEmail());
        $requete->bindValue(':phone', $user->getPhone());
        $requete->bindValue(':portable', $user->getPortable());
        $requete->bindValue(':password', $user->getPassword());
        $requete->bindValue(':salt', $user->getSalt());
        $requete->bindValue(':statusConnected', $user->getStatusConnected(), \PDO::PARAM_INT);
        $requete->bindValue(':activeUser', $user->getActiveUser(), \PDO::PARAM_INT);
        $requete->bindValue(':validationKey', $user->getValidationKey());
        $requete->bindValue(':activatedUser', $user->getActivatedUser());
        $requete->bindValue(':dateCreate', $user->getDateCreate());
        $requete->bindValue(':TypeUser_idTypeUser', $user->getTypeUser_idTypeUser(), \PDO::PARAM_INT);
        $requete->bindValue(':id', $user->getId(), \PDO::PARAM_INT);
        
        $requete->execute();
        $row_count = $requete->rowCount();
        return $row_count;
    }
    
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete(int $id)
    {
        $countUser = $this->dao->exec('DELETE FROM user WHERE id = '.(int) $id);
        if ($countUser == 0) {
            return [ 'type' => 'danger', 'Un problème est survenu. L\'utilisateur n\'a pas été effacé.'];
        }
        return [ 'type' => 'success', 'message' => 'L\'utilisateur a bien été supprimé. '];
    }
    
    /**
     * ifExistPseudo
     *
     * @param  mixed $pseudo
     * @return bool
     */
    public function ifExistPseudo(string $pseudo ) : bool
    {
        $ifExistPseudo = false;
        $requete = $this->dao->query('SELECT COUNT(*) FROM User')->fetchColumn();
        if ($requete > 0) {
            $ifExistPseudo = true;
        }
        return $ifExistPseudo;
    }
    
    /**
     * askPromotion
     *
     * @param  mixed $id
     * @return void
     */
    public function askPromotion(int $id)
    {
        $countUser = $this->dao->exec('UPDATE user SET askpromotion = 1 WHERE id = '.(int) $id);
        if ($countUser == 0) {
            return [ 'type' => 'danger', 'Un problème est survenu. Votre demande n\'a pas aboutie.'];
        }
        return [ 'type' => 'success', 'message' => 'Votre demande est bien enregistrée.'];
    }
    
    /**
     * promote
     *
     * @param  mixed $id
     * @return void
     */
    public function promote(int $id)
    {
        $sql = 'UPDATE user SET TypeUser_idTypeUser = TypeUser_idTypeUser + 1, askPromotion = 0 WHERE id = '.(int) $id;
        $countUser = $this->dao->exec($sql);
        if ($countUser == 0) {
            return [ 'type' => 'danger', 'Un problème est survenu. Votre demande n\'a pas aboutie.'];
        }
        return [ 'type' => 'success', 'message' => 'Promotion bien enregistrée.'];
    }
    
    /**
     * demote
     *
     * @param  mixed $id
     * @return void
     */
    public function demote(int $id)
    {
        $sql = 'UPDATE user SET TypeUser_idTypeUser = TypeUser_idTypeUser - 1 WHERE id = '.(int) $id;
        $countUser = $this->dao->exec($sql);
        if ($countUser == 0) {
            return [ 'type' => 'danger', 'Un problème est survenu. Votre demande n\'a pas aboutie.'];
        }
        return [ 'type' => 'success', 'message' => 'Rétrogradation bien enregistrée.'];
    }
    
    /**
     * ban
     *
     * @param  mixed $id
     * @return void
     */
    public function ban(int $id)
    {
        $countUser = $this->dao->exec('UPDATE user SET activeUser = 0 WHERE id ='. (int) $id);
        if ($countUser == 0) {
            return [ 'type' => 'danger', 'Un problème est survenu. Votre demande n\'a pas aboutie.'];
        }
        return [ 'type' => 'success', 'message' => 'Utilisateur banni.'];
    }
}