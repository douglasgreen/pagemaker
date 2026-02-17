<?php

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Footer component.
 */
class Footer implements Renderable
{
    protected string $template = 'components/footer.html.twig';

    /**
     * @param array<string, array<string, string>> $columns heading => [label => href]
     * @param string $copyright e.g. "© 2026 Acme Inc."
     * @param array<string, string> $socialLinks platform => url
     */
    public function __construct(
        private array $columns = [],
        private string $copyright = '',
        private array $socialLinks = [],
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
            'columns' => $this->columns,
            'copyright' => $this->copyright,
            'social_links' => $this->socialLinks,
        ];
    }
}
