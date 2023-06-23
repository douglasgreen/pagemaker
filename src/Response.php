<?php

namespace PageMaker;

abstract class Response
{
    protected $content;
    protected $statusCode;
    protected $headers;

    abstract public function send(): void;
}
