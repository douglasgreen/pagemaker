<?php

namespace PageMakerDev\Contract;

use PageMakerDev\Registry;
use PageMakerDev\Request;

interface Controller
{
    public function getRegistry(): Registry;
    public function getRequest(): Request;
}
