<?php

namespace PageMaker;

/**
 * @class Session
 *
 * Class for managing sessions and session variables.
 * Remember to properly handle sessions in your application to protect against session-based attacks. Be particularly
 * mindful of session fixation and session hijacking attacks.
 */
class Session
{
    /**
     * Starts a new session if one hasn't already been started.
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Sets a session variable to a specific value.
     *
     * @param string $key The key of the session variable.
     * @param string $value The value to be assigned to the session variable.
     */
    public function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Retrieves the value of a session variable.
     *
     * @param string $key The key of the session variable.
     * @param string|null $default The default value to be returned if the session variable doesn't exist.
     * @return string|null The value of the session variable, or the default value if it doesn't exist.
     */
    public function get(string $key, string $default = null): ?string
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * Checks if a session variable exists.
     *
     * @param string $key The key of the session variable.
     * @return bool True if the session variable exists, false otherwise.
     */
    public function exists(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Removes a session variable.
     *
     * @param string $key The key of the session variable to be removed.
     */
    public function remove(string $key): void
    {
        if ($this->exists($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destroys the entire session.
     */
    public function destroy(): void
    {
        session_destroy();
    }

    /**
     * Regenerates the session ID to prevent session fixation attacks.
     */
    public function regenerate(): void
    {
        session_regenerate_id(true);
    }
}
