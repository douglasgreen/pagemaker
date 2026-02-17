<?php

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Accordion component.
 */
class Accordion implements Renderable
{
    protected string $template = 'components/accordion.html.twig';

    /**
     * @param array<string, string|Renderable> $sections heading => body
     * @param bool $alwaysOpen Allow multiple open sections
     * @param bool $flush Remove borders for edge-to-edge look
     * @param string|null $id
     */
    public function __construct(
        private array $sections,
        private bool $alwaysOpen = false,
        private bool $flush = false,
        private ?string $id = null,
    ) {
        $this->id ??= 'pm-accordion-' . bin2hex(random_bytes(4));
    }

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
        // Resolve any Renderable objects in sections
        $resolvedSections = [];
        foreach ($this->sections as $heading => $body) {
            if ($body instanceof Renderable) {
                $resolvedSections[$heading] = $body->render();
            } else {
                $resolvedSections[$heading] = $body;
            }
        }

        return [
            'sections' => $resolvedSections,
            'always_open' => $this->alwaysOpen,
            'flush' => $this->flush,
            'id' => $this->id,
        ];
    }
}
