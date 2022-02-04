<?php

namespace Lib;

use \lib\Session;

class Utilities
{    
    /**
     * checkDate
     * Checks the validity of a date 
     *
     * @param  mixed $date
     * @return void
     */
    public static function checkDate($date) {
        $dt = \DateTime::createFromFormat("Y/m/d", $date);
        return $dt && $dt->format("Y/m/d") === $date;
    }
    
    /**
     * checkPostalCode
     * Verifies the conformity of a postal code 
     *
     * @param  mixed $code
     * @return void
     */
    public static function checkPostalCode($code) {
        return (preg_match("#^[0-9]{5}$#", $code));
    }
    
    /**
     * RandomToken
     * Generates a random 32-character token 
     *
     * @param  mixed $length
     * @return string
     */
    public static function RandomToken($length = null){
        if(!isset($length) || intval($length) <= 8 ){
          $length = 32;
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
    }
        
    /**
     * Salt
     * Generates a 10 character random key
     *
     * @return string
     */
    public static function Salt(){
        return substr(strtr(base64_encode(hex2bin( self::RandomToken(32))), '+', '.'), 0, 10);
    }
    
    /**
     * password_encode
     * Encode a password with a key 
     *
     * @param  mixed $password
     * @param  mixed $salt
     * @return void
     */
    public static function password_encode($password, $salt)
    {
        return password_hash($password.$salt, PASSWORD_DEFAULT);
    }

    public static function verify_password($password, $salt, $passwordHash)
    {
        return password_verify($password.$salt, $passwordHash);
    }
    
    /**
     * captcha
     * Display and store in session the value of a captcha 
     *
     * @param  mixed $session
     * @return void
     */
    public static function captcha(Session $session)
    {
        $session->setAttribute('captcha', mt_rand(1000,9999));

        $img = imagecreate(65,30);
	    $font = dirname(__DIR__) .'/public/fonts/28_Days_Later.ttf';
	 
	    $textcolor = imagecolorallocate($img,255,255,255); // First use define background color
	    $textcolor = imagecolorallocate($img, 0, 0, 0);    // Second use define text color
	 
	    imagettftext($img, 23, 0, 3, 30, $textcolor, $font, $session->getAttribute('captcha'));
	 
	    header('Content-type:image/jpeg');
	    imagejpeg($img);
	    imagedestroy($img);
    }
    
    /**
     * ViewPicture
     * Allows access to files contained in the public image directory
     *
     * @param  mixed $name
     * @param  mixed $type
     * @return void
     */
    public static function ViewPicture($name, $type)
    {
        if (strtoupper($type) == "PDF") {
            header("Content-type:application/pdf");
            header("Content-Disposition:inline;filename='$name");
            readfile("image/" . $name);
        }
        header("content-type:image/".$type);
        echo file_get_contents("image/" . $name);
    }
}