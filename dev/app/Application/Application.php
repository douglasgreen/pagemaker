<?php

namespace PageMaker\Application;

// @todo Add plugin features to body builder
// The purpose of plugin architecture is separation of features and error checking.
class Application
{
    protected $plugins = [];

    public static function isCli(): bool
    {
        return php_sapi_name() === 'cli';
    }
}
