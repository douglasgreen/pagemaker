<?php

namespace PageMaker;

use Psr\Log\LoggerInterface;
use PDO;

/**
 * @class
 * Here is an example of a base controller class with middleware for logging, authentication and error handling
 * using type hints. This example also assumes you're using PDO for database interactions and Psr\Log\LoggerInterface for
 * logging.
 *
 * In this example, the BaseController class takes a PDO instance and a LoggerInterface instance as dependencies. The
 * middleware method takes an array of middleware names, which it loops through and calls on the current controller
 * instance. The logMiddleware, authMiddleware, and errorMiddleware methods contain the logic for the corresponding
 * middleware, which could be fleshed out depending on your application needs.
 *
 * Please note that middleware in PHP typically isn't handled this way in a real-world application. PHP frameworks
 * often have their own specific way of dealing with middleware. This is a simplified and abstract example and may need
 * further modification to suit your specific needs.
 */
abstract class BaseController
{
    protected $database;
    protected $logger;

    public function __construct(PDO $database, LoggerInterface $logger)
    {
        $this->database = $database;
        $this->logger = $logger;
    }

    // Method to process middleware
    protected function middleware(array $middlewares): void
    {
        foreach ($middlewares as $middleware) {
            call_user_func([$this, $middleware]);
        }
    }

    // Middleware for logging
    protected function logMiddleware(): void
    {
        // logging logic goes here
        $this->logger->info("A request was made to " . __CLASS__);
    }

    // Middleware for authentication
    protected function authMiddleware(): void
    {
        // authentication logic goes here
        // redirect or throw error if not authenticated
    }

    // Middleware for error handling
    protected function errorMiddleware(): void
    {
        // error handling logic goes here
        // log error and show error page if there's an unhandled error
    }

    // Method to handle response
    protected function respond(string $view, array $data = []): void
    {
        // load view and pass in data
    }

    // Abstract method to handle request
    // all child controllers should implement this
    abstract protected function handleRequest(array $request): void;
}
