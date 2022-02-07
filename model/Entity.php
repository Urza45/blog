<?php

namespace Model;

/**
 * Entity
 */
abstract class Entity
{
    protected $errors = [];
    protected $id;
    
    /**
     * __construct
     *
     * @param  mixed $donnees
     * @return void
     */
    public function __construct(array $donnees = [])
    {
        if (!empty($donnees))
        {
        $this->hydrate($donnees);
        }
    }
    
    /**
     * isNew
     *
     * @return void
     */
    public function isNew()
    {
        return empty($this->id);
    }
    
    /**
     * erreurs
     *
     * @return void
     */
    public function erreurs()
    {
        return $this->errors;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
    /**
     * hydrate
     *
     * @param  mixed $donnees
     * @return void
     */
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $attribut => $valeur)
        {
            $methode = 'set'.ucfirst($attribut);

            if (is_callable([$this, $methode]))
            {
                $this->$methode($valeur);
            }
        }
    }
}