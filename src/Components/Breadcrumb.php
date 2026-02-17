<?php

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Breadcrumb navigation component.
 */
class Breadcrumb implements Renderable
{
    protected string $template = 'components/breadcrumb.html.twig';

    /**
     * @param array<string, string|null> $items label => href (null for current/active)
     */
    public function __construct(
        private array $items = [],
    ) {}

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        return '';
    }

    /**
     * Get data for template rendering.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'items' => $this->items,
        ];
    }
}
