<?php

namespace Lib;

/**
 * Session
 */
class Session
{
    private $_SESSION;
    
    public function __construct()
    {
        $this->_SESSION = (isset($_SESSION)) ? $_SESSION : null;
    }
    
    /**
     * start
     * Start or restore the session
     *
     * @return void
     */
    public function start()
    {
        session_start();
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
        return (isset($this->_SESSION[$name]) && $this->_SESSION[$name] != "");
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
            return $this->_SESSION[$name];
        }
        else 
        {
            throw new \Exception("Attribut '$name' absent de la session");
        }
    }
    
    /**
     * existSession
     *
     * @return void
     */
    public function existSession()
    {
        return isset($_SESSION);
    }

}