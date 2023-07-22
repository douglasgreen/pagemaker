<?php

namespace PageMakerDev\Widget;

/**
 * @class Menu
 *
 * // Example usage
 * $menu = new Menu();
 * $menu->addLink('Home', '/');
 * $menu->addLink('About', '/about');
 * $servicesMenu = $menu->addSubmenu('Services');
 * $servicesMenu->addLink('Consulting', '/services/consulting');
 * $servicesMenu->addLink('Support', '/services/support');
 *
 * echo $menu->render();
 */
class Menu extends Widget
{
    protected $name;
    protected $items = [];

    /**
     * Add raw HTML as a menu item.
     */
    public function addHtml(string $name, string $html): void
    {
        $this->items[$name] = $html;
    }

    /**
     * Add a link.
     */
    public function addLink(string $name, string $link): void
    {
        $this->items[$name] = "<a href='$link'>$name</a>";
    }

    /**
     * Add a submenu.
     */
    public function addSubmenu(string $name): Menu
    {
        $submenu = new Menu($name);
        $this->items[$name] = $submenu;
        return $submenu;
    }

    public function render(): string
    {
        $output = '<ul>';
        foreach ($this->items as $name => $item) {
            $output .= "<li>";
            if (is_string($item)) {
                $output .= $item;
            } else {
                $output .= "<span>$name</span>";
                $output .= $item->render();
            }
            $output .= "</li>";
        }
        $output .= '</ul>';
        return $output;
    }
}
