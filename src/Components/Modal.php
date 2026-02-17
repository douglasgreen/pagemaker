<?php

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Modal dialog component.
 */
class Modal implements Renderable
{
    protected string $template = 'components/modal.html.twig';

    /**
     * @param string $title
     * @param string|Renderable $body
     * @param string|null $footerHtml
     * @param string $size ''|'sm'|'lg'|'xl'|'fullscreen'
     * @param bool $centered
     * @param bool $scrollable
     * @param bool $staticBackdrop
     * @param string|null $id
     */
    public function __construct(
        private string $title,
        private string|Renderable $body,
        private ?string $footerHtml = null,
        private string $size = '',
        private bool $centered = true,
        private bool $scrollable = false,
        private bool $staticBackdrop = false,
        private ?string $id = null,
    ) {
        $this->id ??= 'pm-modal-' . bin2hex(random_bytes(4));
    }

    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Return the trigger button HTML.
     */
    public function triggerButton(string $label, string $class = 'btn btn-primary'): string
    {
        return sprintf(
            '<button type="button" class="%s" data-bs-toggle="modal" data-bs-target="#%s">%s</button>',
            $class,
            $this->id,
            $label,
        );
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
        $body = $this->body;
        if ($body instanceof Renderable) {
            $body = $body->render();
        }

        return [
            'title' => $this->title,
            'body' => $body,
            'footer_html' => $this->footerHtml,
            'size' => $this->size,
            'centered' => $this->centered,
            'scrollable' => $this->scrollable,
            'static_backdrop' => $this->staticBackdrop,
            'id' => $this->id,
        ];
    }
}
