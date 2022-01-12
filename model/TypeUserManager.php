<?php

namespace Model;

use \Model\Manager;
use \Model\TypeUser;

class TypeUserManager extends Manager
{
    public function getListType()
    {
        $sql = 'SELECT id, label FROM typeuser ORDER BY label';

        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\TypeUser');

        $listType = $requete->fetchAll();
        
        return $listType;
    }

    public function getLabel(int $id)
    {
        $sql = 'SELECT label FROM typeuser WHERE id ='.$id;
        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\TypeUser');

        $label = $requete->fetchAll();
        
        return $label;
    }
}