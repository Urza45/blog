<?php

namespace Model;

use \Model\Manager;
use \Model\Post;

class PostManager extends Manager
{
    public function getListPosts($number = null)
    {
        $sql = 'SELECT id, title, chapo, content, dateCreate, user_idUser FROM post ORDER By id DESC';
        if (isset($number)) {
            $sql .= ' limit ' . $number;
        }

        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\Post');

        $listPost = $requete->fetchAll();
        
        return $listPost;
    }
}