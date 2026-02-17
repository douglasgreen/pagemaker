<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Form builder component.
 */
class Form implements Renderable
{
    protected string $template = 'components/form.html.twig';

    /**
     * @param string $action Form action URL
     * @param string $method HTTP method
     * @param array $fields Field definitions
     * @param string $submitLabel
     * @param bool $csrfToken Include a CSRF hidden field placeholder
     */
    public function __construct(
        private readonly string $action,
        private readonly string $method = 'POST',
        private readonly array $fields = [],
        private readonly string $submitLabel = 'Submit',
        private readonly bool $csrfToken = true,
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
            'action' => $this->action,
            'method' => $this->method,
            'fields' => $this->fields,
            'submit_label' => $this->submitLabel,
            'csrf_token' => $this->csrfToken,
        ];
    }
}
