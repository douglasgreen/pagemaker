<?php

namespace PageMakerDev\Response;

/**
 * Use this class for CLI response.
 */
class Cli extends Response
{
    protected $content;

    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    public function addContent(string $content): void
    {
        $this->content .= $content;
    }

    public function send(): void
    {
        echo $this->content;
    }

    public function sendError(string $message, int $exitCode = 1): void
    {
        fwrite(STDERR, $message);
        exit($exitCode);
    }
}
