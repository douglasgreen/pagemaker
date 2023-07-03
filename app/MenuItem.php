<?php

namespace PageMaker;

class MenuItem
{
    protected $description;
    protected $link;
    protected $submenu;

    public function __construct($description, $link = null)
    {
        $this->description = $description;
        $this->link = $link;
        $this->submenu = null;
    }

    public function submenu()
    {
        $this->submenu = new Menu();
        return $this->submenu;
    }

    public function build($indentLevel = 0)
    {
        $output = str_repeat(' ', $indentLevel * 4) . "<li>";
        if ($this->link) {
            $output .= "<a href='$this->link'>$this->description</a>";
        } else {
            $output .= "<span>$this->description</span>";
        }
        if ($this->submenu) {
            $output .= "\n" . $this->submenu->build($indentLevel + 1);
            $output .= str_repeat(' ', $indentLevel * 4);
        }
        $output .= "</li>\n";
        return $output;
    }
}
