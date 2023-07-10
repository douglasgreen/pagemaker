<?php

namespace PageMaker\File;

/**
 * @class File uploader.
 *
 * Please remember, handling file uploads can pose significant security risks if not done properly. Always validate and
 * sanitize all input, don't trust user-supplied filenames, and ensure you set file permissions correctly. It is also
 * recommended to check the file type, restrict the file extensions that can be uploaded, and consider virus scanning
 * uploaded files.
 */

class Uploader
{
    protected $destinationDir;

    public function __construct(string $destinationDir)
    {
        $destinationDir = FileHelper::addTrailingSlash($destinationDir);
        if (!is_dir($destinationDir) || !is_writable($destinationDir)) {
            throw new InvalidArgumentException("Directory doesn't exist or isn't writable.");
        }
        $this->destinationDir = $destinationDir;
    }

    public function upload(array $file): string
    {
        // Validate file
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new RuntimeException('Invalid file parameters.');
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }

        // You should also check filesize here.
        if ($file['size'] > 1000000) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        // DO NOT TRUST $file['mime'] VALUE !!
        // Check MIME Type by yourself.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $fileExtensionMap = [
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];

        $uploadedFile = $finfo->file($file['tmp_name']);
        $ext = array_search($uploadedFile, $fileExtensionMap, true);

        if (false === $ext) {
            throw new RuntimeException('Invalid file format.');
        }

        // You should name it uniquely.
        // DO NOT USE $file['name'] WITHOUT ANY VALIDATION !!
        // On this example, obtain safe unique name from its binary data.
        $newFilename = sprintf('%s.%s', sha1_file($file['tmp_name']), $ext);

        if (!move_uploaded_file($file['tmp_name'], $this->destinationDir . $newFilename)) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        return $newFilename;
    }

    public function retrieve(string $filename): string
    {
        $fileFullPath = $this->destinationDir . $filename;

        if (!file_exists($fileFullPath)) {
            throw new RuntimeException('File does not exist.');
        }

        return file_get_contents($fileFullPath);
    }
}
