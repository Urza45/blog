<?php

namespace Lib;

class Session {
    
    /**
     * __construct
     * Start or restore the session
     *
     * @return void
     */
    public function __construct()
    {
        //session_start();
    }
    
    /**
     * destroy
     * Destroy the current session
     *
     * @return void
     */
    public function destroy()
    {
        session_destroy();
        //session_start();
    }
    
    /**
     * setAttribute
     * Add an attribute to the session 
     *
     * @param  mixed $name
     * @param  mixed $value
     * @return void
     */
    public function setAttribute($name, $value)
    {
        $name = htmlspecialchars($name);
        $value = htmlspecialchars($value);
        $_SESSION[$name] = $value;
    }
    
    /**
     * existsAttribute
     * Returns true if the attribute exists in the session 
     *
     * @param  mixed $name
     * @return void
     */
    public function existsAttribute($name)
    {
        return (isset($_SESSION[$name]) && $_SESSION[$name] != "");
    }
    
    /**
     * getAttribute
     * Returns the value of the requested attribute
     * 
     * @param  mixed $name
     * @return void
     */
    public function getAttribute($name)
    {
        if ($this->existsAttribute($name)) 
        {
            return $_SESSION[$name];
        }
        else 
        {
            throw new \Exception("Attribut '$name' absent de la session");
        }
    }

}