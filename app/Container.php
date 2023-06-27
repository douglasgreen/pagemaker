<?php

namespace PageMaker;

/**
 * @class
 * Here is a basic example of how you could create a Dependency Injection Container in PHP.
 *
 * This class Container is capable of managing the dependencies for your application. It has three important methods:
 *
 * bind(): This method binds an interface to an implementation. It's a way of telling the container what implementation to use for a particular interface.
 * resolve(): This method resolves a dependency. It checks if an instance is already created for a certain class or interface. If it exists, it returns the instance, otherwise it creates a new one and stores it before returning it.
 * getInstance(): This method gets the singleton instance of the Container.
 * Please note that this is a simple example and it does not handle cases where dependencies themselves have dependencies. You may need a more sophisticated container for more complex projects.
 *
 * // Usage:
 * $container = Container::getInstance();
 * $container->bind(IExample::class, Example::class);
 * $instance = $container->resolve(IExample::class);
 *
 * Here, IExample is the interface and Example is the class that implements IExample. This setup allows you to easily
 * switch the implementation of IExample without modifying the rest of your code, as long as the new implementation
 * follows the IExample interface.
 *
 * It's important to note that there are mature Dependency Injection Container libraries available for PHP, such as
 * PHP-DI and Symfony's DependencyInjection component, which can handle more complex scenarios and offer additional
 * features.
 */
class Container
{
    protected static $instance;
    protected $instances = [];

    public static function getInstance(): Container
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public static function make(string $concrete)
    {
        return new $concrete();
    }

    public function bind(string $abstract, string $concrete): void
    {
        $this->instances[$abstract] = self::make($concrete);
    }

    public function resolve(string $abstract)
    {
        if (!isset($this->instances[$abstract])) {
            throw new Exception("No instance bound to {$abstract}");
        }
        return $this->instances[$abstract];
    }
}
