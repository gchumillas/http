# HTTP

A library to process HTTP requests and to print document. This library is part of the "Mimbre Framework" and allow us to implement a **C**ontroller and a **V**iew of the [MVC design pattern](http://mvc.com). Specifically, this library contains two classes:

  * `HttpController`: The base class for any controller
  * `HttpView`: The base class for any view
  
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

A controller must extend the `HttpController` class. It processes HTTP requests and performs the corresponding actions.

## The View

## Development notes

```bash
# verifies that the source code conforms the current coding standards
phpcs --standard=phpcs.xml src
```
