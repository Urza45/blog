<?php

namespace Model;

use Model\Manager;
use Model\Post;

/**
 * PostManager
 */
class PostManager extends Manager
{
    /**
     * getListPost
     *
     * @param  mixed $number
     * @return array of Post
     */
    public function getListPost(int $number = null)
    {
        $sql = 'SELECT id, title, chapo, content, dateCreate, user_idUser FROM post ORDER BY id DESC';
        if (isset($number)) {
            $sql .= ' limit ' . $number;
        }

        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\Post');

        $listPost = $requete->fetchAll();

        return $listPost;
    }

    /**
     * getUniquePost
     *
     * @param  mixed $idPost
     * @return instance of User
     */
    public function getUniquePost(int $idPost)
    {
        $requete = $this->dao->prepare('SELECT id, title, chapo, content, dateCreate, user_idUser FROM post WHERE id = :id');
        $requete->bindValue(':id', (int) $idPost, \PDO::PARAM_INT);
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\Post');

        if ($post = $requete->fetch()) {
            return $post;
        }

        return null;
    }

    /**
     * count
     *
     * @return void
     */
    public function count()
    {
        return $this->dao->query('SELECT COUNT(*) FROM post')->fetchColumn();
    }

    /**
     * save
     *
     * @param  mixed $post
     * @return void
     */
    public function save(Post $post)
    {
        if ($post->isValid()) {
            $post->isNew() ? $this->add($post) : $this->modify($post);
        } else {
            throw new \RuntimeException('Votre post doit être validé pour être enregistré.');
        }
    }

    /**
     * add
     *
     * @param  mixed $post
     * @return void
     */
    private function add(Post $post)
    {
        $sql = 'INSERT INTO post SET '
        . 'title = :title,'
        . 'chapo = :chapo, '
        . 'content = :content, '
        . 'dateCreate = NOW(), '
        . 'user_idUser = :user_idUser';
        $requete = $this->dao->prepare($sql);

        $requete->bindValue(':title', $post->getTitle());
        $requete->bindValue(':chapo', $post->getChapo());
        $requete->bindValue(':content', $post->getContent());
        $requete->bindValue(':user_idUser', $post->getUser_idUser());

        $requete->execute();
    }

    /**
     * modify
     *
     * @param  mixed $post
     * @return void
     */
    private function modify(Post $post)
    {
        $sql = 'UPDATE post SET '
        . ' title = :title,'
        . 'chapo = :chapo, '
        . 'content = :content, '
        . 'dateCreate = NOW(), '
        . 'user_idUser = :user_idUser '
        . 'WHERE id = :id';
        $requete = $this->dao->prepare($sql);

        $requete->bindValue(':title', $post->getTitle());
        $requete->bindValue(':chapo', $post->getChapo());
        $requete->bindValue(':content', $post->getContent());
        $requete->bindValue(':user_idUser', $post->getUser_idUser());
        $requete->bindValue(':id', $post->getId(), \PDO::PARAM_INT);

        $requete->execute();
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete(int $idPost)
    {
        $countPost = $this->dao->exec('DELETE FROM post WHERE id = ' . (int) $idPost);
        if ($countPost == 0) {
            return [ 'type' => 'danger', 'Un problème est survenu. Le post n\'a pas été effacé.'];
        }
        $countComment = $this->dao->exec('DELETE FROM comments WHERE Post_idPOST = ' . (int) $idPost);
        return [ 'type' => 'success', 'message' => 'Le post est bien effacé. ' . $countComment . ' commentaire(s) correspondant ont également été supprimés.'];
    }
}
