<?php

namespace Model;

use \Model\Manager;
use \Model\User;

/**
 * UserManager
 */
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
     * @param  mixed $idUser
     * @return instance of User
     */
    public function getUnique(int $idUser)
    {
        $sql = 'SELECT id, name, firstName, pseudo, email, phone, portable,'
        .' password, salt, statusConnected, activeUser, validationKey'
        .' validationKey, activatedUser, dateCreate, typeUser_idTypeUSer, askPromotion'
        .' FROM user WHERE id = :id';
        
        $requete = $this->dao->prepare($sql);
        $requete->bindValue(':id', (int) $idUser, \PDO::PARAM_INT);
        $requete->execute();
    
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\User');
    
        if ($user = $requete->fetch())
        {
            return $user;
        }
    
        return null;
    }
    
    /**
     * getUniqueByPseudo
     *
     * @param  mixed $pseudo
     * @return void
     */
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
            $chaine = 'name = :name,'
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

            if ($user->isNew()) {
                $sql = 'INSERT INTO user SET ' . $chaine;
                //return $this->add($user);
            } else {
                $sql = 'UPDATE user SET ' . $chaine . ' WHERE id = :id';
                //return $this->modify($user);
            }
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
            if (!$user->isNew()) {
                $requete->bindValue(':id', $user->getId(), \PDO::PARAM_INT);
            }
            
            $requete->execute();
            $row_count = $requete->rowCount();
            return $row_count;
        }
        else
        {
            throw new \RuntimeException('Votre User doit être validé pour être enregistré.');
        }
    }
    
    /**
     * delete
     *
     * @param  mixed $idUser
     * @return void
     */
    public function delete(int $idUser)
    {
        $countUser = $this->dao->exec('DELETE FROM user WHERE id = '.(int) $idUser);
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
        $requete = $this->dao->query('SELECT COUNT(*) FROM User WHERE pseudo="' . $pseudo.'"')->fetchColumn();
        if ($requete > 0) {
            $ifExistPseudo = true;
        }
        return $ifExistPseudo;
    }
    
    /**
     * askPromotion
     *
     * @param  mixed $idUser
     * @return void
     */
    public function askPromotion(int $idUser)
    {
        $countUser = $this->dao->exec('UPDATE user SET askpromotion = 1 WHERE id = '.(int) $idUser);
        if ($countUser == 0) {
            return [ 'type' => 'danger', 'Un problème est survenu. Votre demande n\'a pas aboutie.'];
        }
        return [ 'type' => 'success', 'message' => 'Votre demande est bien enregistrée.'];
    }
    
    /**
     * promote
     *
     * @param  mixed $idUser
     * @return void
     */
    public function promote(int $idUser)
    {
        $sql = 'UPDATE user SET TypeUser_idTypeUser = TypeUser_idTypeUser + 1, askPromotion = 0 WHERE id = '.(int) $idUser;
        $countUser = $this->dao->exec($sql);
        if ($countUser == 0) {
            return [ 'type' => 'danger', 'Un problème est survenu. Votre demande n\'a pas aboutie.'];
        }
        return [ 'type' => 'success', 'message' => 'Promotion bien enregistrée.'];
    }
    
    /**
     * demote
     *
     * @param  mixed $idUser
     * @return void
     */
    public function demote(int $idUser)
    {
        $sql = 'UPDATE user SET TypeUser_idTypeUser = TypeUser_idTypeUser - 1 WHERE id = '.(int) $idUser;
        $countUser = $this->dao->exec($sql);
        if ($countUser == 0) {
            return [ 'type' => 'danger', 'Un problème est survenu. Votre demande n\'a pas aboutie.'];
        }
        return [ 'type' => 'success', 'message' => 'Rétrogradation bien enregistrée.'];
    }
    
    /**
     * ban
     *
     * @param  mixed $idUser
     * @return void
     */
    public function ban(int $idUser)
    {
        $countUser = $this->dao->exec('UPDATE user SET activeUser = 0 WHERE id ='. (int) $idUser);
        if ($countUser == 0) {
            return [ 'type' => 'danger', 'Un problème est survenu. Votre demande n\'a pas aboutie.'];
        }
        return [ 'type' => 'success', 'message' => 'Utilisateur banni.'];
    }
    
    /**
     * active
     *
     * @param  mixed $idUser
     * @return void
     */
    public function active(int $idUser)
    {
        $countUser = $this->dao->exec('UPDATE user SET activeUser = 1 WHERE id ='. (int) $idUser);
        if ($countUser == 0) {
            return [ 'type' => 'danger', 'Un problème est survenu. Votre demande n\'a pas aboutie.'];
        }
        return [ 'type' => 'success', 'message' => 'Utilisateur activé.'];
    }
    
    /**
     * getCode
     *
     * @param  mixed $idUser
     * @return void
     */
    public function getCode(int $idUser)
    {
        $sql = 'SELECT code FROM user WHERE id = :id';

        $requete = $this->dao->prepare($sql);

        $requete->bindValue(':id', $idUser, \PDO::PARAM_INT);

        $requete->execute();
        
        return $requete->fetch();
    }
    
    /**
     * saveCode
     *
     * @param  mixed $code
     * @param  mixed $id
     * @return void
     */
    public function saveCode($code, $idUser)
    {
        $sql = 'UPDATE user SET '
        . 'code = :code '
        . 'WHERE id = :id';
        
        $requete = $this->dao->prepare($sql);

        $requete->bindValue(':code', $code, \PDO::PARAM_INT);
        $requete->bindValue(':id', $idUser, \PDO::PARAM_INT);

        $requete->execute();
        $row_count = $requete->rowCount();
        return $row_count;

    }
}