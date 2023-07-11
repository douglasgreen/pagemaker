<?php

namespace PageMaker\Responses;

class Json extends Response
{
    protected $data;
    protected $statusCode;
    protected $headers = ['Content-Type' => 'application/json'];

    public static function sendError(string $message): void
    {
        http_response_code(400);
        $data = [];
        $data['status'] = 'error';
        $data['message'] = $message;
        echo json_encode($data);
    }

    public function __construct(string $data = [], int $statusCode = 200, array $headers = [])
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
