<?php
namespace mimbre\http;
use mimbre\http\data\HttpParam;
use mimbre\http\exception\HttpException;

/**
 * Processes HTTP requests and performs actions according
 * to the request method.
 *
 * Example:
 *
 *    $c = new HttpController();
 *
 *    // adds some 'request listeners'
 *    $c->onOpen(function () {
 *        echo "Opening request\n";
 *    });
 *    $c->onGet(function () {
 *        echo "Processing GET request\n";
 *    });
 *    $c->onPost(function () {
 *        echo "Processing POST request\n";
 *    });
 *    $c->onClose(function () {
 *        echo "Closing request\n";
 *    });
 *
 *    // processes the HTTP request
 *    $c->processRequest();
 */
class HttpController
{
    /**
    * List of listeners.
    * 
    * @var {method: string[], callbacks[]}[]
    */
    private $_listeners = [];

    /**
    * Gets a parameter.
    *
    * Examples:
    *
    *    // Gets a cookie with a default value
    *    $page = $this->get("page", ["default" => "0"]);
    *
    *    // The parameter `username` is required.
    *    $username = $this->get("username", ["required" => "true"]);
    *
    * @param string $name    Parameter name
    * @param array  $options Options (not required)
    *
    * @return mixed
    */
    public function getParam($name, $options = [])
    {
        $required = isset($options["required"]) ? $options["required"] : false;
        $param = HttpParam::get($name, $options);

        if ($required && strlen($param) == 0) {
            throw new HttpException("The parameter `$name` is required");
        }

        return $param;
    }

    /**
    * Adds a request listener.
    *
    * Example:
    *
    *    $c = new HttpController();
    *    $c->on("PUT", function () {
    *        echo "Processing PUT request\n";
    *    });
    *    $c->processRequest();
    *
    * @param string   $method   Method name (GET, POST, PUT, etc...)
    * @param callable $listener Request listener
    *
    * @return void
    */
    public function on($method, $listener)
    {
        if (!array_key_exists($method, $this->_listeners)) {
            $this->_listeners[$method] = [];
        }

        array_push($this->_listeners[$method], $listener);
    }

    /**
    * Adds an 'OPEN' request listener.
    *
    * 'OPEN' request listeners are called at first place, before any other
    * request listeners.
    *
    * @param callable $listener Request listener
    *
    * @return void
    */
    public function onOpen($listener)
    {
        $this->on("OPEN", $listener);
    }

    /**
    * Adds a 'GET' request listener.
    *
    * @param callable $listener Request listener
    *
    * @return void
    */
    public function onGet($listener)
    {
        $this->on("GET", $listener);
    }

    /**
    * Adds a 'POST' request listener.
    *
    * @param callable $listener Request listener
    *
    * @return void
    */
    public function onPost($listener)
    {
        $this->on("POST", $listener);
    }

    /**
    * Adds a 'CLOSE' listener.
    *
    * @param callable $listener Request listener
    *
    * @return void
    */
    public function onClose($listener)
    {
        $this->on("CLOSE", $listener);
    }

    /**
    * Processes the request.
    *
    * @return void
    */
    public function processRequest()
    {
        $requestMethods = ["OPEN", $_SERVER["REQUEST_METHOD"], "CLOSE"];

        foreach ($requestMethods as $requestMethod) {
            if (!array_key_exists($requestMethod, $this->_listeners)) {
                continue;
            }

            $listeners = $this->_listeners[$requestMethod];
            foreach ($listeners as $listener) {
                call_user_func($listener);
            }
        }
    }
}
