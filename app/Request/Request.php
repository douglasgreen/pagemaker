<?php

namespace PageMaker\Request;

/**
 * @class Request handler
 *
 * Here's a very simple example of a Request class that wraps the PHP superglobals. It uses the filterInput function
 * to sanitize the input values.
 *
 * Please note that the filterInput function is a simplistic way to sanitize input and may not be appropriate for all
 * situations. You should use more comprehensive validation and sanitization techniques depending on the specific needs
 * of your application.
 *
 * This Request class includes methods to access the $_GET, $_POST, $_SERVER, $_FILES, and $_COOKIE superglobals. The
 * get, post, server, files, and cookies methods retrieve a value from the corresponding superglobal. If the key is not
 * present in the superglobal, they return a default value.
 *
 * The isPost and isGet methods can be used to determine the HTTP method of the request. The filterInput function
 * sanitizes the input values. It's a protected method used by the other methods to retrieve and sanitize values from the
 * superglobals.
 *
 * Remember to use more complex validation and sanitization logic for real applications. The filter_var function with
 * the FILTER_SANITIZE_FULL_SPECIAL_CHARS filter may not be appropriate for all situations. For example, you may need
 * different sanitization for email addresses, URLs, integers, etc.
 */
class Request
{
    protected $get;
    protected $post;
    protected $server;
    protected $files;
    protected $cookies;

    public static function filterInput(array $input, string $key, $default)
    {
        return isset($input[$key]) ? filter_var($input[$key], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $default;
    }

    public function __construct()
    {
        global $argv;  // Access to the command line arguments

        // Check if the script is running in a command line interface (CLI) environment
        if (Application::isCli()) {
            // Create an empty array to store our GET data, equivalent to the $_GET superglobal in a web environment
            $this->get = [];

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
                    $this->get[$name] = $value;
                }
                // Move on to the next argument
                $i++;
            }
        } else {
            // For a non-CLI environment, populate the relevant properties from the superglobals
            $this->get = $_GET;      // Contains all GET request parameters
            $this->post = $_POST;    // Contains all POST request parameters
            $this->server = $_SERVER; // Contains server and execution environment information
            $this->files = $_FILES;   // Contains all file items which were uploaded
            $this->cookies = $_COOKIE; // Contains all COOKIE data
        }
    }

    public function get(string $key, $default = null)
    {
        return self::filterInput($this->get, $key, $default);
    }

    public function post(string $key, $default = null)
    {
        return self::filterInput($this->post, $key, $default);
    }

    public function server(string $key, $default = null)
    {
        return self::filterInput($this->server, $key, $default);
    }

    public function files(string $key, $default = null)
    {
        return self::filterInput($this->files, $key, $default);
    }

    public function cookies(string $key, $default = null)
    {
        return self::filterInput($this->cookies, $key, $default);
    }

    public function isPost(): bool
    {
        return $this->server('REQUEST_METHOD') === 'POST';
    }

    public function isGet(): bool
    {
        return $this->server('REQUEST_METHOD') === 'GET';
    }
}
