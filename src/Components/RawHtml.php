<?php

declare(strict_types=1);

namespace App\Layout\Components;

use App\Layout\Renderable;

// Simple wrapper for raw HTML strings
class RawHtml implements Renderable
{
    public function __construct(private readonly string $html) {}

    public function render(): string
    {
        return $this->html;
    }
}
