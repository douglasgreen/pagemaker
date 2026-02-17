<?php

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Form builder component.
 */
class Form implements Renderable
{
    protected string $template = 'components/form.html.twig';

    /**
     * @param string $action      Form action URL
     * @param string $method      HTTP method
     * @param array  $fields      Field definitions
     * @param string $submitLabel
     * @param bool   $csrfToken   Include a CSRF hidden field placeholder
     */
    public function __construct(
        private string $action,
        private string $method = 'POST',
        private array $fields = [],
        private string $submitLabel = 'Submit',
        private bool $csrfToken = true,
    ) {}

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

    public function __toString(): string
    {
        return $this->render();
    }
}
