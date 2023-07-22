<?php

namespace PageMakerDev;

use PageMakerDev\Utility\PhpConfig;
use PageMakerDev\Contract\Request as RequestInterface;

/**
 * @class Request handler
 *
 * Here's a simple request class that wraps the PHP superglobals.
 *
 * This Request class includes methods to access the $_GET, $_POST, $_SERVER, $_FILES, and $_COOKIE superglobals. The
 * get, post, server, file, and cookie methods retrieve a value from the corresponding superglobal. If the key is not
 * present in the superglobal, they return a default value.
 *
 * The filter_var function with the FILTER_SANITIZE_FULL_SPECIAL_CHARS filter may not be appropriate for all
 * situations. For example, you may need different sanitization for email addresses, URLs, integers, etc.
 *
 * For testing, fake superglobal arrays can be injected to the constructor. Otherwise, the built-in superglobals are
 * accessed directly rather than being copied to save memory.
 */
class Request implements RequestInterface
{
    protected $getVars;
    protected $postVars;
    protected $serverVars;
    protected $cookies;
    protected $files;

    public function __construct(
        ?array $getVars = null,
        ?array $postVars = null,
        ?array $serverVars = null,
        ?array $files = null,
        ?array $cookies = null,
    ) {
        global $argv;  // Access to the command line arguments

        // Check if the script is running in a command line interface (CLI) environment
        if (PhpConfig::isCli()) {
            $this->getVars = $this->processArgv();
        } else {
            // For a non-CLI environment, populate the relevant properties from the superglobals
            $this->getVars = $getVars;
            $this->postVars = $postVars;
            $this->serverVars = $serverVars;
            $this->files = $files;
            $this->cookies = $cookies;
        }
    }

    /**
     * This is just a reader. Update cookie with Cookie handler.
     */
    public function cookie(string $key, $default = null, $useFilter = false)
    {
        if (isset($this->cookies)) {
            $value = $this->cookies[$key] ?? $default;
        } else {
            $value = $_COOKIE[$key] ?? $default;
        }

        if ($useFilter) {
            $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        return $value;
    }

    public function get(string $key, $default = null, $useFilter = false)
    {
        if (isset($this->getVars)) {
            $value = $this->getVars[$key] ?? $default;
        } else {
            $value = $_GET[$key] ?? $default;
        }

        if ($useFilter) {
            $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        return $value;
    }

    /**
     * This is just a reader. Process the result with file Uploader.
     */
    public function file(string $key, $default = null, $useFilter = false)
    {
        if (isset($this->files)) {
            $value = $this->files[$key] ?? $default;
        } else {
            $value = $_FILES[$key] ?? $default;
        }

        if ($useFilter) {
            $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        return $value;
    }

    public function post(string $key, $default = null, $useFilter = false)
    {
        if (isset($this->postVars)) {
            $value = $this->postVars[$key] ?? $default;
        } else {
            $value = $_POST[$key] ?? $default;
        }

        if ($useFilter) {
            $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        return $value;
    }

    public function server(string $key, $default = null, $useFilter = false)
    {
        if (isset($this->serverVars)) {
            $value = $this->serverVars[$key] ?? $default;
        } else {
            $value = $_SERVER[$key] ?? $default;
        }

        if ($useFilter) {
            $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        return $value;
    }

    protected function processArgv(): array
    {
            // Create an empty array to store our GET data, equivalent to the $_GET superglobal in a web environment
            $get = [];

            // This will hold the names of the options (command line arguments starting with '--')
            $optionNames = [];

            // Loop over each command line argument
        foreach ($argv as $arg) {
            // Using regex to check if the argument starts with '--' (i.e., it's a long option)
            // If so, it captures the name (the part after '--') and stores it in $optionNames array
            // If not, it adds false to $optionNames to keep the indexes in sync with $argv
            if (preg_match('/^--(?<name>\w+)$/', $arg, $match)) {
                $optionNames[] = $match['name'];
            } else {
                $optionNames[] = false;
            }
        }

            // Counter for looping through arguments
            $i = 0;
            // Total number of arguments
            $n = count($argv);

            // Loop over the command line arguments
        while ($i < $n) {
            // Check if the current item in optionNames is not false (i.e., it is an option name)
            if ($optionNames[$i] !== false) {
                $name = $optionNames[$i];

                // If the current argument is the last one, or the next argument is also an option name
                // (meaning, the current option doesn't have a value), we assign true to the current option
                // This indicates that the option was provided, but no specific value was given
                if (!isset($argv[$i + 1]) || $optionNames[$i + 1] !== false) {
                    $value = true;  // The option is present but doesn't have a specific value
                } else {
                    // Else, the value of the option is the next argument
                    // Increase $i to skip the value in the next iteration
                    $value = $argv[++$i];
                }

                // Add the option and its value to the get array
                $get[$name] = $value;
            }
            // Move on to the next argument
            $i++;
        }
            return $get;
    }
}
