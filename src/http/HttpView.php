<?php
namespace mimbre\http;
use mimbre\http\exception\HttpException;
use mimbre\http\HttpController;

/**
 * The base class for any 'view'.
 */
abstract class HttpView
{
    protected $controller;

    /**
    * Constructor.
    *
    * @param HttpController $controller Controller
    */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    /**
    * Gets the document.
    *
    * @return mixed
    */
    abstract public function getDocument();

    /**
    * Prints the document.
    *
    * Returns a 'client exception' if an exception has occurred.
    *
    * @return void
    */
    public function printDocument()
    {
        try {
            $this->controller->processRequest();
        } catch (HttpException $e) {
            $message = substr(
                preg_replace('/\s+/', ' ', $e->getMessage()), 0, 150
            );
            header("HTTP/1.0 400 $message");
            throw $e;
        }

        echo $this->getDocument();
    }
}
