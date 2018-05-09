# HTTP

A library to process HTTP requests and print document. This library is part of the "Mimbre Framework" and allow us to implement a **C**ontroller and a **V**iew from the [MVC design pattern](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller). Specifically, this library contains two classes:

  * `HttpController`: The base class of any controller
  * `HttpView`: The base class of any view
  
## Install

This library uses the [Composer package manager](https://getcomposer.org/). Simply execute the following command from a terminal:

```bash
composer require mimbre\http
```

Or add the following line to your `composer.json` file:

```text
{
  ...
  "require": {
    ...
    "mimbre/http-json": "^1.0"
  }
}
```
  
## The Controller

A 'controller' must extend the `HttpController` class. It processes HTTP requests and performs the corresponding actions. For example:

```php
header("Content-Type: text/plain; charset=utf-8");
require_once "path/to/vendor/autoload.php";
use mimbre\http\HttpController;

class MyController extends HttpController {
  public function __construct() {
    // registers requests handlers
    $this->onOpen([$this, "open"]);
    $this->onGet([$this, "get"]);
    $this->on("DELETE", [$this, "delete"]);
    $this->onPost([$this, "post"]);
    $this->onClose([$this, "close"]);
  }

  // This request handler is called before any other handler, and it's
  // a good place to initialize resources, such as database connections, etc...
  public function open() {
    echo "Opening request...\n";
  }

  // This request handler processes 'GET requests'.
  public function get() {
    $param1 = $this->getParam("param1", ["default" => "Param 1"]);
    $param2 = $this->getParam("param2");

    echo "Processing GET request...\n";
  }

  // This request handler processes 'DELETE requests'.
  public function delete() {
    echo "Processing DELETE request...\n";
  }

  // This request handler processes 'POST requests'
  public function post() {
    $param1 = $this->getParam("param1", ["default" => "Param 1"]);
    $param2 = $this->getParam("param2");

    echo "Processing POST request...\n";
  }

  // This request handler is called after any other handler, and it's
  // a good place to close resources, such as database connections, etc....
  public function close() {
    echo "Closing request...\n";
  }
}

// Creates an instance of MyController and processes the request
$c = new MyController();
$c->done();
```

## The View

A 'view' is in charge of printing documents and must extends the `HttpView` class, which contains an abstract method called `getDocument()`. For example:

```php
header("Content-Type: text/plain; charset=utf-8");
require_once "path/vendor/autoload.php";
use mimbre\http\HttpController;
use mimbre\http\HttpView;
use mimbre\http\exception\HttpException;

class MyController extends HttpController {
  public $username = "";

  public function __construct() {
    $this->onGet([$this, "get"]);
  }

  // This request handler processes 'GET requests'.
  public function get() {
    $this->username = $this->getParam("username");

    if (strlen($this->username) == 0) {
      throw new HttpException("Username is required");
    }
  }
}

class MyView extends HttpView {
  public function __construct() {
    // The HttpView constructor accepts a controller as parameter
    parent::__construct(new MyController());
  }

  // This abstract method must be implemented
  public function getDocument() {
    return "Hi there, " . $this->controller->username . "!";
  }
}

// creates an instance and prints the document
$view = new MyView();
$view->printDocument();
```

## Development notes

```bash
# verifies that the source code conforms the current coding standards
phpcs --standard=phpcs.xml src
```
