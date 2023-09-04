<?php

namespace PageMaker;

use PageMaker\Contract\Request as RequestInterface;

/**
 * @class Request handler
 *
 * Here's a simple request class that wraps the PHP superglobals.
 *
 * This Request class includes methods to access the $_GET, $_POST, $_SERVER, $_FILES, and $_COOKIE superglobals. The
 * get, post, server, file, and cookie methods retrieve a value from the corresponding superglobal. If the key is not
 * present in the superglobal, they return a default value.
 *
 * For testing, fake superglobal arrays can be injected to the constructor. Otherwise, the built-in superglobals are
 * accessed directly rather than being copied to save memory.
 */
class Request implements RequestInterface
{
    protected $data = [
        'arg' => null,
        'cookie' => null,
        'file' => null,
        'get' => null,
        'post' => null,
        'server' => null,
    ];

    public function set(string $type, array $data): void
    {
        if (!array_key_exists($type, $this->data)) {
            throw new LibraryException('Invalid type');
        }

        if ($type == 'arg') {
            $this->data[$type] = $this->processArgv($data);
        } else {
            $this->data[$type] = $data;
        }
    }

    public function get(string $type, string $key, $default = null)
    {
        if (!array_key_exists($type, $this->data)) {
            throw new LibraryException('Invalid type');
        }

        switch ($type) {
            case 'arg':
                if (isset($this->data['arg'])) {
                    $value = $this->data['arg'][$key] ?? $default;
                } else {
                    global $argv;
                    $this->data['arg'] = $this->processArgv($data);
                    $value = $this->data['arg'][$key] ?? $default;
                }
                break;
            case 'cookie':
                if (isset($this->data['cookie'])) {
                    $value = $this->data['cookie'][$key] ?? $default;
                } else {
                    $value = $_COOKIE[$key] ?? $default;
                }
                break;
            case 'get':
                if (isset($this->data['get'])) {
                    $value = $this->data['get'][$key] ?? $default;
                } else {
                    $value = $_GET[$key] ?? $default;
                }
                break;
            case 'file':
                if (isset($this->data['file'])) {
                    $value = $this->data['file'][$key] ?? $default;
                } else {
                    $value = $_FILES[$key] ?? $default;
                }
                break;
            case 'post':
                if (isset($this->data['post'])) {
                    $value = $this->data['post'][$key] ?? $default;
                } else {
                    $value = $_POST[$key] ?? $default;
                }
                break;
            case 'server':
                if (isset($this->data['server'])) {
                    $value = $this->data['server'][$key] ?? $default;
                } else {
                    $value = $_SERVER[$key] ?? $default;
                }
                break;
        }
        return $value;
    }

    /**
     * Process only long-named arguments from the argv array, equivalent to the $_GET superglobal in a web environment.
     */
    protected function processArgv($argv): array
    {
        // Create an empty array to store our GET data, equivalent to the $_GET superglobal in a web environment
        $args = [];

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
                $args[$name] = $value;
            }
            // Move on to the next argument
            $i++;
        }
        return $args;
    }
}
