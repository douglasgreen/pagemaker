<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker;

interface Renderable
{
    public function render(): string;
}
