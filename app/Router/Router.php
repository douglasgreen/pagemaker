<?php

namespace PageMaker\Router;

use Exception;

/**
 * @class Router
 *
 * This router assumes that you have a corresponding controller for each page. For instance, if you route to
 * page=user&action=show, it expects to have a UserController class with a getShow or postShow method, depending on
 * the HTTP method.
 *
 * Remember to autoload your classes, so they're available when you need them, or use a PSR-4 autoloader such as the
 * one provided by Composer. Also, you may need to implement more complex routing mechanisms to deal with optional
 * parameters, query strings, and more, and remember to sanitize and validate all input data.
 */
class Router
{
    protected $action;
    protected $namespace;
    protected $page;
    protected $registry;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->page = $request->page ?? 'home';
        $this->action = $request->action ?? 'view';
        $this->method = $request->server('REQUEST_METHOD') ?? 'get';
    }

    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    public function setRegistry(Registry $registry): void
    {
        $this->registry = $registry;
    }

    public function route(): Response
    {
        // Create the class and method names
        $className = ucfirst(strtolower($this->page)) . 'Controller';
        if ($this->namespace) {
            $className = $this->namespace . '\\' . $className;
        }

        // Check if the class exists
        if (!class_exists($className)) {
            throw new Exception("Class '$className' not found");
        }

        $object = new $className();

        $object->setRequest($this->request);
        if ($this->registry) {
            $object->setRegistry($this->registry);
        }

        // Check if the method exists
        $methodName = strtolower($this->method) . ucfirst(strtolower($this->action));
        if (!method_exists($object, $methodName)) {
            throw new Exception("Method '$methodName' not found in class '$className'");
        }

        // Call the method
        $response = $object->$methodName();

        return $response;
    }
}
