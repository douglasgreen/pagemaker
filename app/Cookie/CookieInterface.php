<?php

namespace PageMaker\Cookie;

interface CookieInterface
{
    /**
     * Set a new cookie
     *
     * @param string $name
     * @param string $value
     * @param int $expiry in seconds
     */
    public static function set(string $name, string $value, int $expiry): void

    /**
     * Get a cookie value
     *
     * @param string $name
     * @return string|null
     */
    public static function get(string $name): ?string;

    /**
     * Update a cookie value
     *
     * @param string $name
     * @param string $value
     * @param int $expiry in seconds
     */
    public static function update(string $name, string $value, int $expiry): void;

    /**
     * Delete a cookie
     *
     * @param string $name
     */
    public static function delete(string $name): void;
}
