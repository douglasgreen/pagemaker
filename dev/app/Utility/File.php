<?php

namespace PageMakerDev\Utility;

use PageMakerDev\LibraryException;

/**
 * @class
 * This is quite a simplified version and real-world applications could require a lot more error handling and security
 * checks.
 *
 * Each function in this class is designed to perform one of the operations you requested.
 *
 * `readFile`: reads and returns the content of a file.
 * `writeFile`: writes data to a file.
 * `deleteFile`: deletes a file.
 * `createDirectory`: creates a directory.
 *
 * Please note that these functions don't handle all possible error situations. You might want to extend them to make
 * sure they cover all edge cases according to your requirements.
 *
 * Please also note that this kind of operation can have security implications, and you should be careful to validate
 * and sanitize all inputs to these functions, and ensure that they can only be used to manipulate files in a way that
 * is safe and conforms to your application's requirements.
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

    /**
     * Create a directory.
     *
     * @param string $dirPath
     * @param int $permissions
     * @return bool
     */
    public static function createDirectory(string $dirPath, int $permissions = 0777): bool
    {
        if (!file_exists($dirPath)) {
            return mkdir($dirPath, $permissions, true);
        }

        return false;
    }

    /**
     * Delete a file.
     *
     * @param string $filepath
     * @return bool
     * @throws LibraryException
     */
    public static function deleteFile(string $filepath): bool
    {
        if (file_exists($filepath)) {
            return unlink($filepath);
        }

        return true;
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

    /**
     * Read a file.
     *
     * @param string $filepath
     * @return string
     * @throws LibraryException
     */
    public static function readFile(string $filepath): string
    {
        if (!file_exists($filepath)) {
            throw new LibraryException("File does not exist: {$filepath}");
        }

        return file_get_contents($filepath);
    }

    /**
     * Write data to a file.
     *
     * @param string $filepath
     * @param string $data
     * @return bool
     */
    public static function writeFile(string $filepath, string $data): bool
    {
        $file = fopen($filepath, "w");
        if ($file) {
            fwrite($file, $data);
            fclose($file);
            return true;
        } else {
            return false;
        }
    }
}
