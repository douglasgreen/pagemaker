<?php
namespace App\Layout\Components;

use App\Layout\Renderable;

// Alert Collection
class AlertCollection implements Renderable {
    private array $alerts = [];
    
    public function add(string $message, string $type = 'danger', bool $dismissible = true): void {
        $this->alerts[] = compact('message', 'type', 'dismissible');
    }
    
    public function isEmpty(): bool {
        return empty($this->alerts);
    }
    
    public function render(): string {
        $html = '';
        foreach ($this->alerts as $alert) {
            $dismiss = $alert['dismissible'] ? 'alert-dismissible fade show' : '';
            $btn = $alert['dismissible'] ? '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' : '';
            $html .= sprintf(
                '<div class="alert alert-%s %s rounded-0 mb-0">%s%s</div>',
                $alert['type'], $dismiss, htmlspecialchars($alert['message']), $btn
            );
        }
        return $html;
    }
}
