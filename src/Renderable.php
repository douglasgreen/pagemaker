<?php

declare(strict_types=1);

namespace App\Layout;

interface Renderable
{
    public function render(): string;
}
