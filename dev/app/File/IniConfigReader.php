<?php

namespace PageMakerDev\File;

use PageMakerDev\LibraryException;

/**
 * @class A simple PHP class that reads INI files with section support.
 *
 * This class ConfigReader loads an INI file in the constructor and parses it into a multidimensional array with parse_ini_file. There are two public methods:
 *
 * get(string $section, string $key): This method is used to retrieve a specific configuration value from a specific section.
 *
 * getSection(string $section): This method is used to retrieve all configuration values from a specific section.
 *
 * Both methods will throw an LibraryException if the requested section or key does not exist.
 */
class IniConfigReader
{
    protected $configData;

    /**
     * ConfigReader constructor.
     * @param string $filePath
     * @throws LibraryException
     */
    public function __construct(string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new LibraryException("File does not exist: {$filePath}");
        }

        $this->configData = parse_ini_file($filePath, true);

        if ($this->configData === false) {
            throw new LibraryException("Failed to parse INI file: {$filePath}");
        }
    }

    /**
     * @param string $section
     * @param string $key
     * @return mixed
     * @throws LibraryException
     */
    public function get(string $section, string $key)
    {
        if (!isset($this->configData[$section])) {
            throw new LibraryException("Section does not exist: {$section}");
        }

        if (!isset($this->configData[$section][$key])) {
            throw new LibraryException("Key does not exist: {$key} in section: {$section}");
        }

        return $this->configData[$section][$key];
    }

    /**
     * @param string $section
     * @return array
     * @throws LibraryException
     */
    public function getSection(string $section): array
    {
        if (!isset($this->configData[$section])) {
            throw new LibraryException("Section does not exist: {$section}");
        }

        return $this->configData[$section];
    }
}
