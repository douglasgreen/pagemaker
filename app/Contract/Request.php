<?php

namespace PageMaker\Contract;

interface Request
{
    public function get(string $type, string $key);
}
