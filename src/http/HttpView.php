<?php
namespace movicon\http;
use \Exception;
use movicon\http\HttpController;

/**
 * The base class for any 'view'.
 */
abstract class HttpView
{
    protected $controller;
    private $_contentType;
    private $_charset;

    /**
    * Constructor.
    *
    * @param HttpController $controller Controller
    */
    public function __construct(
        $controller,
        $contentType = "text/plain; charset=utf-8",
        $charset = "utf-8"
    ) {
        $this->controller = $controller;
        $this->_contentType = $contentType;
        $this->_charset = $charset;
    }

    /**
    * Gets the document.
    *
    * @return string
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
        header("Content-Type: {$this->_contentType}; {$this->_charset}");

        try {
            $this->controller->processRequest();
        } catch (Exception $e) {
            $message = substr(
                preg_replace('/\s+/', ' ', $e->getMessage()), 0, 150
            );
            header("HTTP/1.0 400 $message");
            throw $e;
        }

        echo $this->getDocument();
    }
}
