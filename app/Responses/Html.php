<?php

namespace PageMaker\Responses;

class HtmlResponse extends Response
{
    protected $content;
    protected $statusCode;
    protected $headers;

    public static function sendError(string $message, int $statusCode = 500): void
    {
        http_response_code($statusCode);
        echo $message;
        exit;
    }

    public function __construct(string $content = '', int $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function addContent(string $content): void
    {
        $this->content .= $content;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function setHeader(string $header, string $value): void
    {
        $this->headers[$header] = $value;
    }

    public function send(): void
    {
        // Set status code
        http_response_code($this->statusCode);

        // Set headers
        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }

        // Send content
        echo $this->content;
    }
}
