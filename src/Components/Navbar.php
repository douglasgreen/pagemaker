<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Bootstrap navbar component.
 */
class Navbar implements Renderable
{
    protected string $template = 'components/navbar.html.twig';

    /**
     * @param array<string, string> $items label => href
     * @param string|null $brandLogo Optional logo URL
     * @param string $theme 'light'|'dark'
     * @param bool $fixed Sticky top?
     * @param string $breakpoint Collapse breakpoint infix (e.g. 'lg')
     */
    public function __construct(
        private readonly string $brandName,
        private readonly string $brandUrl = '/',
        private readonly ?string $brandLogo = null,
        private readonly array $items = [],
        private readonly string $theme = 'dark',
        private readonly bool $fixed = true,
        private readonly string $breakpoint = 'lg',
    ) {}

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        // This will be overridden by template rendering
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
            'brand_name' => $this->brandName,
            'brand_url' => $this->brandUrl,
            'brand_logo' => $this->brandLogo,
            'items' => $this->items,
            'theme' => $this->theme,
            'fixed' => $this->fixed,
            'breakpoint' => $this->breakpoint,
        ];
    }
}
