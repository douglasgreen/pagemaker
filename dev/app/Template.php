<?php

namespace PageMaker;

/**
 * @class Template engine
 *
 * Responsible for setting up, configuring, and rendering PHP templates.
 */
class Template
{
    /**
     * Holds the path to the directory containing the templates
     * @var string
     */
    protected $directory;

    /**
     * Holds variables that are passed to the templates
     * @var array
     */
    public $variables = [];

    /**
     * Constructor initializes the template variables
     */
    public function __construct(string $directory)
    {
        $this->setTemplateDirectory($directory);
    }

    /**
     * Updates the template directory
     *
     * @param string $directory
     */
    public function setTemplateDirectory(string $directory): void
    {
        $this->directory = FileHelper::addTrailingSlash($directory);
    }

    /**
     * Attempts to render a template, given its filename
     *
     * @param string $filename
     * @return string The rendered template
     * @throws LibraryException If the template file does not exist
     */
    public function render($filename)
    {
        ob_start();

        // Check if the file exists before including it
        if (file_exists($this->directory . $filename)) {
            include($this->directory . $filename);
        } else {
            throw new LibraryException("Template not found");
        }

        return ob_get_clean();
    }

    /**
     * Magic setter for assigning values to template variables
     * @todo Add automatic translation.
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->variables[$key] = htmlspecialchars($value);
    }

    /**
     * Magic getter for accessing template variables
     *
     * @param string $key
     * @return mixed|null The value of the variable, or null if it doesn't exist
     */
    public function __get($key)
    {
        return array_key_exists($key, $this->variables) ? $this->variables[$key] : null;
    }

    public function setRaw($key, $value)
    {
        $this->variables[$key] = $value;
    }
}
