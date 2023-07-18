<?php

namespace PageMaker\Cookie;

/**
 * @class Manage cookies.
 *
 * This is a simple implementation and may not be suitable for all use cases. For example, it doesn't handle error
 * conditions, or deal with cookie attributes beyond the value and expiration time. Depending on your needs, you might
 * want to expand this class to handle these and other situations.
 */

class Cookie implements CookieInterface
{
    /**
     * Set a new cookie
     *
     * @param string $name
     * @param string $value
     * @param int $expiry in seconds
     */
    public static function set(string $name, string $value, int $expiry): void
    {
        if (!isset($_COOKIE[$name])) {
            setcookie($name, $value, time() + $expiry, "/");
        }
    }

    /**
     * Get a cookie value
     *
     * @param string $name
     * @return string|null
     */
    public static function get(string $name): ?string
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    /**
     * Update a cookie value
     *
     * @param string $name
     * @param string $value
     * @param int $expiry in seconds
     */
    public static function update(string $name, string $value, int $expiry): void
    {
        if (isset($_COOKIE[$name])) {
            // Set the cookie again with the new value and updated expiration time
            setcookie($name, $value, time() + $expiry, "/");
        }
    }

    /**
     * Delete a cookie
     *
     * @param string $name
     */
    public static function delete(string $name): void
    {
        if (isset($_COOKIE[$name])) {
            // Set the cookie with a past expiration date to delete it
            setcookie($name, "", time() - 3600, "/");
        }
    }
}
