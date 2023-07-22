<?php

namespace PageMakerDev\Contract;

use PageMakerDev\Utility\PhpConfig;

/**
 * Handles retrieval of $_GET, $_POST, $_SERVER, and $_COOKIE vars from a request.
 *
 * $_REQUEST is not offered. Use $_GET and $_POST instead.
 *
 * @interface Request
 */
interface Request
{
    /**
     * Retrieves a value from the $_COOKIE superglobal based on a given key.
     *
     * @param string $key The key to look up in the $_COOKIE superglobal.
     *
     * @return mixed|null The value associated with the key, or null if the key is not set.
     */
    public function cookie(string $key);

    /**
     * Retrieves a value from the $_FILE superglobal based on a given key.
     *
     * @param string $key The key to look up in the $_FILE superglobal.
     *
     * @return mixed|null The value associated with the key, or null if the key is not set.
     */
    public function file(string $key);

    /**
     * Retrieves a value from the $_GET superglobal based on a given key.
     *
     * @param string $key The key to look up in the $_GET superglobal.
     *
     * @return mixed|null The value associated with the key, or null if the key is not set.
     */
    public function get(string $key);

    /**
     * Retrieves a value from the $_POST superglobal based on a given key.
     *
     * @param string $key The key to look up in the $_POST superglobal.
     *
     * @return mixed|null The value associated with the key, or null if the key is not set.
     */
    public function post(string $key);

    /**
     * Retrieves a value from the $_SERVER superglobal based on a given key.
     *
     * @param string $key The key to look up in the $_SERVER superglobal.
     *
     * @return mixed|null The value associated with the key, or null if the key is not set.
     */
    public function server(string $key);
}
