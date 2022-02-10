<?php

namespace Lib;

/**
 * Security
 */
class Security
{
    const CONNECTED_USER = 1;
    const MODERATOR_USER = 2;
    const ADMINISTRATOR_USER = 3;
    const SUPER_ADMIN_USER = 4;
    
    /**
     * verifAccess
     *
     * @param  mixed $session
     * @param  mixed $level
     * @return void
     */
    public static function verifAccess(Session $session, $level)
    {
        if ($session->existsAttribute('admin')) {
            if ($session->getAttribute('admin') >= $level) {
                return true;
            }
            return false;
        }
        return false;
    }
}
