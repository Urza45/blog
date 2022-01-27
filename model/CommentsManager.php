<?php

namespace Model;

use \Model\Manager;
use \Model\Comments;

class CommentsManager extends Manager
{
    
    /**
     * getList
     *
     * @param  mixed $number
     * @return array
     */
    public function getList(int $number = null)
    {
        $sql = 'SELECT id, content, user_idUser, post_idPost, date, disabled FROM comments ORDER BY id DESC';
        if (isset($number)) {
            $sql .= ' limit ' . $number;
        }

        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\Comments');

        $listComments = $requete->fetchAll();
        
        return $listComments;
    }

    public function getListFromPost(int $number)
    {
        $sql = 'SELECT comments.id, content, user_idUser, post_idPost, user.pseudo, date, disabled FROM comments, user '
            . 'WHERE post_idPost=' . $number. ' AND user.id=user_idUser '
            . 'ORDER BY comments.id DESC';
        
        $requete = $this->dao->query($sql);
    
        $listComments = $requete->fetchAll();
            
        return $listComments;
    }
    
    /**
     * getUnique
     *
     * @param  mixed $id
     * @return void
     */
    public function getUnique(int $id)
    {
        $requete = $this->dao->prepare('SELECT id, content, user_idUser, post_idPost, date, disabled FROM comments WHERE id = :id');
        $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $requete->execute();
    
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\Comments');
    
        if ($comments = $requete->fetch())
        {
            return $comments;
        }
    
        return null;
    }
    
    /**
     * count
     *
     * @return void
     */
    public function count(int $id = null)
    {
        if (isset($id)) {
            return $this->dao->query('SELECT COUNT(*) FROM comments WHERE post_idPost = '.$id)->fetchColumn();
        } else {
            return $this->dao->query('SELECT COUNT(*) FROM comments')->fetchColumn();
        }
    }
    
    /**
     * save
     *
     * @param  mixed $post
     * @return void
     */
    public function save(Comments $comments)
    {
        if ($comments->isValid())
        {
            $comments->isNew() ? $this->add($comments) : $this->modify($comments);
        }
        else
        {
            throw new \RuntimeException('Votre commentaire doit être validé pour être enregistré.');
        }
    }
    
    /**
     * add
     *
     * @param  mixed $post
     * @return void
     */
    private function add(Comments $comments)
    {
        $sql = 'INSERT INTO comments SET '
        . 'content = :content,'
        . 'user_idUser = :user_idUser, '
        . 'post_idPost = :post_idPost, '
        . 'date = NOW(), '
        . 'disabled = :disabled';
        $requete = $this->dao->prepare($sql);

        $requete->bindValue(':content', $comments->getContent());
        $requete->bindValue(':user_idUser', $comments->getUser_idUser());
        $requete->bindValue(':post_idPost', $comments->getPost_idPost());
        $requete->bindValue(':disabled', 0);
    
        $requete->execute();
    } 

    /**
     * modify
     *
     * @param  mixed $post
     * @return void
     */
    private function modify(Comments $comments)
    {
        $sql = 'UPDATE comments SET '
        . 'content = :content,'
        . 'user_idUser = :user_idUser, '
        . 'post_idPost = :post_idPost, '
        . 'date = NOW(), '
        . 'disabled = :disabled '
        . 'WHERE id = :id';
        $requete = $this->dao->prepare($sql);
    
        $requete->bindValue(':content', $comments->getContent());
        $requete->bindValue(':user_idUser', $comments->getUser_idUser());
        $requete->bindValue(':post_idPost', $comments->getPost_idPost());
        $requete->bindValue(':disabled', $comments->getDisabled());;
        $requete->bindValue(':id', $comments->getId(), \PDO::PARAM_INT);
    
        $requete->execute();
    }
    
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete(int $id)
    {
        $countComment = $this->dao->exec('DELETE FROM comments WHERE id = '.(int) $id);
        if ($countComment == 0) {
            return [ 'type' => 'danger', 'message' => 'Un problème est survenu. Le commentaire n\'a pas été effacé.'];
        }
        return [ 'type' => 'success', 'message' => 'Le commentaire est bien effacé.'];
    }
    
    /**
     * ban
     *
     * @param  mixed $id
     * @param  mixed $disabled
     * @return void
     */
    public function ban(int $id, int $disabled)
    {
        $sql = 'UPDATE comments SET disabled = '. $disabled .' WHERE id = '.(int) $id;

        $countComment = $this->dao->exec($sql);
        if ($disabled == 1 ) {
            if ($countComment == 0) {
                return [ 'type' => 'danger', 'message' => 'Un problème est survenu. Le commentaire n\'a pas été interdit.'];
            } 
            return [ 'type' => 'success', 'message' => 'Le commentaire est bien interdit.'];
        } else {
            if ($countComment == 0) {
                return [ 'type' => 'danger', 'message' => 'Un problème est survenu. Le commentaire n\'a pas été autorisé.'];
            }
            return [ 'type' => 'success', 'message' => 'Le commentaire est bien autorisé.'];
        }
        
    }


}