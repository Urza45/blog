<?php

namespace Lib;

/**
 * FormValidator
 */
class FormValidator
{
    /**
     * Check if is not empty and purify
     *
     * @param mixed $param
     *
     * @return mixed $param
     */
    public static function purify($data)
    {
        if ((isset($data) && ($data != ''))) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

            return $data;
        }
    }

    /**
     * Check if is not empty
     *
     * @param $data
     *
     * @return bool
     */
    public static function purifyContent($data)
    {
        if (isset($data) && ($data != '')) {
            return $data;
        }
    }

    /**
     * Check if is alpha
     *
     * @param $value
     *
     * @return bool
     */
    public static function isAlpha($value)
    {
        if (preg_match('/^[a-zA-Z]+$/', $value) && !empty($value)) {
            return true;
        }
    }

    /**
     * Check if alphanumeric
     *
     * @param $value
     *
     * @return bool
     */
    public static function isAlphanum($value)
    {
        if (preg_match('/^[a-zA-Z0-9_]+$/', $value) && !empty($value)) {
            return true;
        }
    }

    /**
     * Check if is email
     *
     * @param $value
     *
     * @return bool
     */
    public static function isEmail($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) && !empty($value)) {
            return true;
        }
    }
}
