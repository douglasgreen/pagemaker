<?php

namespace PageMaker\Contract;

use PageMaker\Registry;
use PageMaker\Request;

interface Controller
{
    public function getRegistry(): Registry;
    public function getRequest(): Request;
}
