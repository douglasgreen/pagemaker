<?php

namespace PageMaker\Control;

use PageMaker\Registry;
use PageMaker\Request;

interface ControllerInterface
{
    public function getRegistry(): Registry;
    public function getRequest(): Request;
}
