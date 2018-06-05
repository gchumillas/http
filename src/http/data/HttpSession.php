<?php
namespace mimbre\http\data;

class HttpSession
{
    /**
    * Gets a session variable.
    *
    * Example:
    *
    *    $token = HttpSession::get("token");
    *    $username = HttpSession::get("username", ["default" => "root"]);
    *
    * @param string $name    Session variable name
    * @param array  $options Options
    *
    * @return mixed|null
    */
    public static function get($name, $options = [])
    {
        HttpSession::_start();

        $default = isset($options["default"]) ? $options["default"] : null;

        return isset($_SESSION[$name]) ? $_SESSION[$name] : $default;
    }

    /**
    * Sets a session variable.
    *
    * @param string $name  Variable name
    * @param mixed  $value Value
    *
    * @return void
    */
    public static function set($name, $value)
    {
        HttpSession::_start();

        $_SESSION[$name] = $value;
    }

    /**
    * Deletes a session variable.
    *
    * @param string $name Variable name
    *
    * @return void
    */
    public static function del($name)
    {
        HttpSession::_start();

        unset($_SESSION[$name]);
    }

    /**
    * Starts a session, if not already started.
    *
    * @return void
    */
    private static function _start()
    {
        if (strlen(session_id()) == 0) {
            session_start();
        }
    }
}
