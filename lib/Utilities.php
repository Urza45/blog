<?php

namespace Lib;

use \lib\Session;

class Utilities
{
    public static function checkDate($date) {
        return (preg_match('#^([0-9]{2})(/-)([0-9]{2})\2([0-9]{4})$#', $date, $m) == 1 && checkdate($m[3], $m[1], $m[4]));
    }

    public static function checkPostalCode($code) {
        return (preg_match("#^[0-9]{5}$#", $code));
    }

    public static function RandomToken($length = null){
        if(!isset($length) || intval($length) <= 8 ){
          $length = 32;
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
    }
    
    public static function Salt(){
        return substr(strtr(base64_encode(hex2bin(self::RandomToken(32))), '+', '.'), 0, 10);
    }

    public static function password_encode($password, $salt)
    {
        return password_hash($password.$salt, PASSWORD_DEFAULT);
    }

    public static function verify_password($password, $salt, $passwordHash)
    {
        return password_verify($password.$salt, $passwordHash);
    }

    public static function captcha(Session $session)
    {
        $session->setAttribute('captcha', mt_rand(1000,9999));

        $img = imagecreate(65,30);
	    $font = dirname(__DIR__) .'/public/fonts/28_Days_Later.ttf';
	 
	    $bg = imagecolorallocate($img,255,255,255);
	    $textcolor = imagecolorallocate($img, 0, 0, 0);
	 
	    imagettftext($img, 23, 0, 3, 30, $textcolor, $font, $session->getAttribute('captcha'));
	 
	    header('Content-type:image/jpeg');
	    imagejpeg($img);
	    imagedestroy($img);
    }
}