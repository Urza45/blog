<?php

namespace Model;

abstract class Entity
{
    protected $errors = [];
    protected $id;

    public function __construct(array $donnees = [])
    {
        if (!empty($donnees))
        {
        $this->hydrate($donnees);
        }
    }

    public function isNew()
    {
        return empty($this->id);
    }

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