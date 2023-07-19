<?php

namespace PageMaker\Control;

use PageMaker\Registry;
use PageMaker\Request;

interface ControllerInterface
{
    public function setRegistry(Registry $registry): void;
    public function setRequest(Request $request): void;

    public function getRegistry(): Registry;
    public function getRequest(): Request;
}
