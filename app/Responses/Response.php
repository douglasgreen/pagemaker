<?php

namespace PageMaker\Responses;

abstract class Response
{
    protected $content;
    protected $statusCode;
    protected $headers;

    abstract public function send(): void;
}
