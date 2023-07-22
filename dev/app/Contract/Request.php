<?php

namespace PageMakerDev\Contract;

interface Request
{
    public function get(string $type, string $key);
}
