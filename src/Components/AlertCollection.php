<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Renderable;

// Alert Collection
class AlertCollection implements Renderable
{
    /** @var array<int, array{message: string, type: string, dismissible: bool}> */
    private array $alerts = [];

    public function add(string $message, string $type = 'danger', bool $dismissible = true): void
    {
        $this->alerts[] = ['message' => $message, 'type' => $type, 'dismissible' => $dismissible];
    }

    public function isEmpty(): bool
    {
        return $this->alerts === [];
    }

    public function render(): string
    {
        $html = '';
        foreach ($this->alerts as $alert) {
            $dismiss = $alert['dismissible'] ? 'alert-dismissible fade show' : '';
            $btn = $alert['dismissible']
                ? '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Dismiss alert"></button>'
                : '';

            // Determine appropriate role based on alert type
            $role = in_array($alert['type'], ['danger', 'warning'], true)
                ? 'alert'
                : 'status';

            $html .= sprintf(
                '<div class="alert alert-%s %s rounded-0 mb-0" role="%s" aria-live="polite">%s%s</div>',
                $alert['type'],
                $dismiss,
                $role,
                htmlspecialchars($alert['message'], ENT_QUOTES, 'UTF-8'),
                $btn,
            );
        }

        return $html;
    }
}
