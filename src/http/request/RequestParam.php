<?php
namespace mimbre\http\request;

class RequestParam
{
    /**
    * Gets a parameter.
    *
    * Examples:
    *
    *    // Gets a cookie with a default value
    *    $page = RequestParam::get("page", ["default" => "0"]);
    *
    * @param string $name    Parameter name
    * @param array  $options Options
    *
    * @return mixed|null
    */
    public static function get($name, $options = [])
    {
        $default = isset($options["default"]) ? $options["default"] : null;

        return isset($_REQUEST[$name]) ? $_REQUEST[$name]: $default;
    }

    /**
    * Sets a parameter.
    *
    * @param string $name  Parameter name
    * @param mixed  $value Value
    *
    * @return void
    */
    public static function set($name, $value)
    {
        $_REQUEST[$name] = $value;
    }

    /**
    * Deletes a parameter.
    *
    * @param string $name Parameter name
    *
    * @return void
    */
    public static function del($name)
    {
        unset($_REQUEST[$name]);
    }
}
