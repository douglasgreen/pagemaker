<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker\Components;

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

        // Auto-add security attributes for external links
        $attrs .= $this->getExternalLinkAttributes();

        return sprintf(
            '<a class="nav-link %s" href="%s" %s>%s</a>',
            $active,
            htmlspecialchars($this->url),
            $attrs,
            htmlspecialchars($this->label),
        );
    }

    private function getExternalLinkAttributes(): string
    {
        // Detect external links (starts with http:// or https:// and not same domain)
        if (preg_match('#^https?://#', $this->url)) {
            return ' rel="noopener noreferrer"';
        }

        return '';
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
