<?php

namespace PageMaker;

// A plugin extends this class. It adds scripts, add styles, or adds output to an ID.
abstract class BasePlugin
{
    protected $scripts = [];
    protected $styles = [];

    abstract public function addScript();
    abstract public function addStyle();
    abstract public function getName();
    abstract public function render();
}
