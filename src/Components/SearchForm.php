<?php

declare(strict_types=1);

namespace App\Layout\Components;

use App\Layout\Renderable;

// Search Form Component
class SearchForm implements Renderable
{
    public function __construct(
        private readonly string $action,
        private readonly string $placeholder = 'Search...',
        private readonly string $method = 'GET',
    ) {}

    public function render(): string
    {
        return sprintf(
            '<form class="d-flex" action="%s" method="%s">
                <input class="form-control me-2" type="search" placeholder="%s" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>',
            htmlspecialchars($this->action),
            htmlspecialchars($this->method),
            htmlspecialchars($this->placeholder),
        );
    }
}
