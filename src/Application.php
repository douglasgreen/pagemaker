<?php

namespace PageMaker;

class Application
{
    public static function isCli(): bool
    {
        return php_sapi_name() === 'cli';
    }
}
