<?php

namespace PageMaker;

/**
 * @class Logger
 *
 * This simple logger class provides methods for logging messages at three levels of severity: info, warning, and
 * error. Each message is logged with a timestamp for convenience.
 *
 * You might want to add more features to your logger class, like support for different log formats, different storage
 * backends (like databases or remote logging services), or different ways to handle critical errors (like sending
 * email notifications), depending on your specific needs.
 *
 *
 * Please note: If you're using this in a production environment, you should handle failures from file_put_contents
 * (for example, if the disk is full, or if the file permissions are incorrect), and you should ensure that sensitive
 * information does not get written into your log files.
 */

class Logger
{
    protected $logPath;

    // Log levels
    const INFO = 'INFO';
    const WARNING = 'WARNING';
    const ERROR = 'ERROR';

    public static function info(string $message)
    {
        self::log(self::INFO, $message);
    }

    public static function warning(string $message)
    {
        self::log(self::WARNING, $message);
    }

    public static function error(string $message)
    {
        self::log(self::ERROR, $message);
    }

    public function __construct(string $logPath)
    {
        $this->logPath = $logPath;
    }

    public function log(string $level, string $message)
    {
        $time = date('Y-m-d H:i:s');
        $log = sprintf("[%s] [%s]: %s" . PHP_EOL, $time, $level, $message);

        file_put_contents($this->logPath, $log, FILE_APPEND);
    }
}
