<?php

namespace PageMakerDev\Utility;

use PageMakerDev\LibraryException;

/**
 * @class File-related functions
 */
class File
{
    /**
     * Add a trailing slash.
     */
    public static function addTrailingSlash(string $path): string
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        return $path;
    }

    public static function findProjectRoot(): string
    {
        $dir = __DIR__;
        while ($dir !== '/') {
            if (is_dir($dir . '/vendor')) {
                return $dir;
            }
            $dir = dirname($dir);
        }

        throw new LibraryException('Project root not found. Please ensure that the vendor directory is installed by Composer.');
    }
}
