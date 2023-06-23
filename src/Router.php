<?php

namespace PageMaker;

use Exception;

/**
 * @class Router
 *
 * This router assumes that you have a corresponding controller for each page. For instance, if you route to
 * page=users&action=show, it expects to have a UsersController class with a getShow or postShow method, depending on
 * the HTTP method.
 *
 * Remember to autoload your classes, so they're available when you need them, or use a PSR-4 autoloader such as the
 * one provided by Composer. Also, you may need to implement more complex routing mechanisms to deal with optional
 * parameters, query strings, and more, and remember to sanitize and validate all input data.
 */
class Router
{
    protected $page;
    protected $action;
    protected $request;
    protected $allowedHttpMethods = array('get', 'post');

    function __construct(Request $request, string $namespace = null)
    {
        $this->request = $request;
        $this->page = $request->page ?? 'home';
        $this->action = $request->action ?? 'view';
        $this->method = $request->method ?? 'get';

        if (!in_array($this->method, $this->allowedHttpMethods)) {
            throw new Exception('Unexpected HTTP method');
        }

        $this->namespace = $namespace;
    }

    function route(string $namespace = null): Response
    {
        // Create the class and method names
        $className = ucfirst(strtolower($this->page)) . 'Controller';
        if ($this->namespace) {
            $className = $this->namespace . '\\' . $className;
        }
        $methodName = strtolower($this->method) . ucfirst(strtolower($this->action));

        // Check if the class exists
        if (!class_exists($className)) {
            throw new Exception("Class '$className' not found");
        }

        $object = new $className();

        // Check if the method exists
        if (!method_exists($object, $methodName)) {
            throw new Exception("Method '$methodName' not found in class '$className'");
        }

        // Call the method
        $response = $object->$methodName($this->request);

        return $response;
    }
}
