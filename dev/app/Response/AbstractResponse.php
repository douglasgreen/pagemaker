<?php

namespace PageMaker\Response;

abstract class AbstractResponse
{
    protected $content;
    protected $statusCode;
    protected $headers;

    abstract public function send(): void;
}
