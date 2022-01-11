<?php

namespace Lib;

class Utilities
{
    public static function checkDate($date) {
        return (preg_match('#^([0-9]{2})(/-)([0-9]{2})\2([0-9]{4})$#', $date, $m) == 1 && checkdate($m[3], $m[1], $m[4]));
    }

    public static function checkPostalCode($code) {
        return (preg_match("#^[0-9]{5}$#", $code));
    }

    public static function RandomToken($length){
        if(!isset($length) || intval($length) <= 8 ){
          $length = 64;
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
    }
    
    public static function Salt(){
        return substr(strtr(base64_encode(hex2bin(self::RandomToken(32))), '+', '.'), 0, 44);
    }
}