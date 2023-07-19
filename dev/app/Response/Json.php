<?php

namespace PageMaker\Response;

class Json extends Response
{
    protected $data;
    protected $statusCode;
    protected $headers = ['Content-Type' => 'application/json'];

    // @todo Use https://datatracker.ietf.org/doc/html/rfc7807#section-3.1 format and allow more error codes.
    public static function sendError(string $message): void
    {
        http_response_code(400);
        $data = [];
        $data['status'] = 400;
        $data['message'] = $message;
        echo json_encode($data);
    }

    public function __construct(array $data = [], int $statusCode = 200, array $headers = [])
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->headers = array_merge($this->headers, $headers);
    }

    public function setField(string $field, $value): void
    {
        $this->data[$field] = $value;
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
        echo json_encode($this->data);
    }
}
