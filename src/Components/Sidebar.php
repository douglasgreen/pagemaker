<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Sidebar navigation component.
 */
class Sidebar implements Renderable
{
    protected string $template = 'components/sidebar.html.twig';

    /**
     * @param array<array{icon:string, label:string, href:string, active?:bool, children?:array}> $navItems
     * @param string|null $heading Optional heading above navigation
     */
    public function __construct(
        /** @var array<array{icon:string, label:string, href:string, active?:bool, children?:array}> */
        private readonly array $navItems = [],
        private readonly ?string $heading = null,
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
            'nav_items' => $this->navItems,
            'heading' => $this->heading,
        ];
    }
}
