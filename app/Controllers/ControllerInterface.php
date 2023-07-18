<?php

namespace PageMaker\Controller;

use PageMaker\Registry;
use PageMaker\Request;

interface ControllerInterface
{
    protected function setRegistry(Registry $registry): void;
    protected function setRequest(Request $request): void;

    protected function getRegistry(): Registry;
    protected function getRequest(): Request;
}
