<?php

namespace Flyn\Xenforo;

class Helpers
{
    /**
     * Pass given variables to a file and return its contents
     *
     * @param string $filepath
     * @param array $vars
     * @return string
     */
    public static function requireWith($filepath, $vars = [])
    {
        extract($vars);

        ob_start();
            require $filepath;
        return ob_get_clean();
    }

    /**
     * Return the current URL
     *
     * @return string
     */
    public static function currentUrl()
    {
        return "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }

    /**
     * Retrieve a GET variable
     *
     * @param string $var
     * @param mixed $default
     * @return mixed
     */
    public static function GET($var, $default = null)
    {
        return isset($_GET[$var]) ? $_GET[$var] : $default;
    }

    /**
     * Retrieve a POST variable
     *
     * @param string $var
     * @param mixed $default
     * @return mixed
     */
    public static function POST($var, $default = null)
    {
        return isset($_POST[$var]) ? $_POST[$var] : $default;
    }

    /**
     * Retrieve a REQUEST variable
     *
     * @param string $var
     * @param mixed $default
     * @return mixed
     */
    public static function REQUEST($var, $default = null)
    {
        return isset($_REQUEST[$var]) ? $_REQUEST[$var] : $default;
    }

    /**
     * Retrieve a SERVER variable
     *
     * @param string $var
     * @param mixed $default
     * @return mixed
     */
    public static function SERVER($var, $default = null)
    {
        return isset($_SERVER[$var]) ? $_SERVER[$var] : $default;
    }

    public static function numberConverter($number)
    {
        if ($number >= 1000000) {
            return number_format(($number / 1000000), 1) . 'M';
        } elseif ($number >= 1000) {
            return number_format(($number / 1000), 1) . 'K';
        } else {
            return $number;
        }
    }
}
