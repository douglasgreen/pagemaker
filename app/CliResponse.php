<?php

namespace PageMaker;

/**
 * Use this class for CLI response.
 */
class CliResponse extends Response
{
    private $content;

    public function __construct(string $content = '')
    {
        echo $content;
    }

    public function addContent(string $content): void
    {
        echo $content;
    }

    public function send(): void
    {
    }

    public function sendError(string $message, int $exitCode = 1): void
    {
        fwrite(STDERR, $message);
        exit($exitCode);
    }
}
