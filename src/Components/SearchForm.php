<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Renderable;

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
            '<form class="d-flex" action="%s" method="%s" role="search">
                <label for="search-input" class="visually-hidden">%s</label>
                <input id="search-input" class="form-control me-2" type="search"
                       placeholder="%s" name="q" autocomplete="off">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>',
            htmlspecialchars($this->action),
            htmlspecialchars($this->method),
            htmlspecialchars($this->placeholder),
            htmlspecialchars($this->placeholder),
        );
    }
}
