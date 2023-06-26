<?php

namespace PageMaker;

class MenuItem {
    private $description;
    private $link;
    private $submenu;

    public function __construct($description, $link = null) {
        $this->description = $description;
        $this->link = $link;
        $this->submenu = null;
    }

    public function submenu() {
        $this->submenu = new Menu();
        return $this->submenu;
    }

    public function build() {
        $output = "<li>";
        if ($this->link) {
            $output .= "<a href=\"{$this->link}\">{$this->description}</a>";
        } else {
            $output .= $this->description;
        }
        if ($this->submenu) {
            $output .= $this->submenu->build();
        }
        $output .= "</li>";
        return $output;
    }
}
