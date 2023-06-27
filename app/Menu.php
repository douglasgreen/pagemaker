<?php

namespace PageMaker;

/**
 * @class Menu
 *
 * In this script, we have two classes: Menu and MenuItem. Menu is responsible for managing an array of menu items,
 * which can be either links or other Menu objects (for submenus). MenuItem represents a single item in the menu, which
 * may be a link or a submenu. Each MenuItem object has a submenu method which can be used to add a submenu to the
 * item, which returns the new Menu object for you to add items to. The build methods in both classes are responsible
 * for generating the HTML for the menu.
 *
 *
 * // Example usage
 * $menu = new Menu();
 * $menu->add('Home', '/');
 * $menu->add('About', '/about');
 * $servicesMenu = $menu->add('Services')->submenu();
 * $servicesMenu->add('Consulting', '/services/consulting');
 * $servicesMenu->add('Support', '/services/support');
 *
 * echo $menu->build();
 */
class Menu
{
    private $items = array();

    public function add($description, $link = null)
    {
        $item = new MenuItem($description, $link);
        array_push($this->items, $item);
        return $item;
    }

    public function build()
    {
        $output = "<ul>";
        foreach ($this->items as $item) {
            $output .= $item->build();
        }
        $output .= "</ul>";
        return $output;
    }
}
