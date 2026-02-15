<?php

declare(strict_types=1);

namespace App\Layout\Components;

use App\Layout\MenuStyle;
use App\Layout\Renderable;

class Menu implements Renderable
{
    /** @var array<int, MenuItem> */
    private array $items = [];

    private MenuStyle $style = MenuStyle::SIDEBAR;

    public function setStyle(MenuStyle $style): self
    {
        $this->style = $style;
        return $this;
    }

    public function addLink(string $label, string $url, bool $active = false): self
    {
        $this->items[] = new Link($label, $url, $active);
        return $this;
    }

    /**
     * @param array<int, array{0: string, 1: string}> $links
     */
    public function addDropdown(string $label, array $links): self
    {
        $dropdown = new Dropdown($label);
        foreach ($links as $link) {
            $dropdown->addItem(new Link($link[0], $link[1]));
        }

        $this->items[] = $dropdown;
        return $this;
    }

    public function render(): string
    {
        if ($this->style === MenuStyle::NAVBAR) {
            return $this->renderNavbar();
        }

        return $this->renderSidebar();
    }

    private function renderNavbar(): string
    {
        $html = '<ul class="navbar-nav me-auto mb-2 mb-lg-0">';
        foreach ($this->items as $item) {
            $html .= '<li class="nav-item">' . $item->render() . '</li>';
        }

        return $html . '</ul>';
    }

    private function renderSidebar(): string
    {
        $html = '<nav class="nav flex-column">';
        foreach ($this->items as $item) {
            if ($item instanceof Link) {
                // Replace nav-link with specific sidebar styling if needed
                $html .= str_replace('nav-link', 'nav-link text-dark', $item->render());
            } else {
                $html .= $item->render();
            }
        }

        return $html . '</nav>';
    }
}
