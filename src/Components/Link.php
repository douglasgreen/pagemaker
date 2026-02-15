<?php

declare(strict_types=1);

namespace App\Layout\Components;

class Link implements MenuItem
{
    /**
     * @param array<string, string|int|bool> $attributes
     */
    public function __construct(
        private readonly string $label,
        private readonly string $url,
        private readonly bool $active = false,
        private readonly array $attributes = [],
    ) {}

    public function render(): string
    {
        $active = $this->active ? 'active' : '';
        $attrs = $this->renderAttributes();
        return sprintf(
            '<a class="nav-link %s" href="%s" %s>%s</a>',
            $active,
            htmlspecialchars($this->url),
            $attrs,
            htmlspecialchars($this->label),
        );
    }

    private function renderAttributes(): string
    {
        return implode(' ', array_map(
            fn (string $k, string|int|bool $v): string => sprintf('%s="%s"', $k, htmlspecialchars((string) $v)),
            array_keys($this->attributes),
            $this->attributes,
        ));
    }
}
