<?php
namespace mimbre\http\request;

class RequestCookie
{
    /**
    * Gets a cookie.
    *
    * Example:
    *
    *    // gets a cookie and returns '123' if the cookie does not exist
    *    $token = RequestCookie::get("token", ["default" => "123"]);
    *
    * @param string $name    Cookie name
    * @param array  $options Options (not required)
    *
    * @return mixed|null
    */
    public static function get($name, $options = [])
    {
        $default = isset($options["default"]) ? $options["default"] : null;

        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
    }

    /**
    * Sets a cookie.
    *
    * Example:
    *
    *    // the cookie expires in one year and its available in the root domain
    *    RequestCookie::set("token", "123");
    *
    *    // the cookie expires in 24h and it's available in /my-app folder
    *    $expireTime = 24 * 60 * 60; // the cookie expires in 24 hours
    *    RequestCookie::set(
    *        "token", "123", ["expire" => $expireTime, "path" => "/my-app"]
    *    );
    *
    * @param string $name    Cookie name
    * @param string $value   Cookie value
    * @param array  $options Options
    *
    * @return void
    */
    public static function set($name, $value, $options = [])
    {
        // default expiration time is one year
        $expirationTime = isset($options["expire"])
            ? $options["expire"]
            : 365 * 24 * 60 * 60;
        $path = isset($options["path"]) ? $options["path"] : "/";
        $domain = isset($options["domain"]) ? $options["domain"] : null;
        $secure = isset($options["secure"]) ? $options["secure"] : false;
        $httponly = isset($options["httponly"]) ? $options["httponly"] : false;

        setcookie(
            $name,
            $value,
            time() + $expirationTime,
            $path,
            $domain,
            $secure,
            $httponly
        );
    }

    /**
    * Deletes a cookie.
    *
    * @param string $name Cookie name
    *
    * @return void
    */
    public static function del($name)
    {
        setcookie($name, null, time() - 3600, "/");
        unset($_COOKIE[$name]);
    }
}
