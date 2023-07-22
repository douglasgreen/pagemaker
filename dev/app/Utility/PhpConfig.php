<?php

namespace PageMakerDev\Utility;

class PhpConfig
{
    public static function isCli(): bool
    {
        return php_sapi_name() === 'cli';
    }
}
