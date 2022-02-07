<?php

namespace Model;

use \Model\Manager;

/**
 * TypeUserManager
 */
class TypeUserManager extends Manager
{    
    /**
     * getListType
     *
     * @return void
     */
    public function getListType()
    {
        $sql = 'SELECT id, label FROM typeuser ORDER BY label';

        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\TypeUser');

        $listType = $requete->fetchAll();
        
        return $listType;
    }
    
    /**
     * getLabel
     *
     * @param  mixed $id
     * @return void
     */
    public function getLabel(int $id)
    {
        $sql = 'SELECT id,label FROM typeuser WHERE id ='.$id;
        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\TypeUser');

        $label = $requete->fetch();
        
        return $label;
    }
}