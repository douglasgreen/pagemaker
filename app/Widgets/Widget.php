<?php

namespace PageMaker\Widgets;

/**
 * A widget extends this class. It adds scripts, add styles, and output.
 * The purpose of widget architecture is separation of features and error checking
 * @todo Add section builder to add divs to section?
 */
class Widget
{
    protected $content = '';
    protected $data;
    protected $name;
    protected $scripts = [];
    protected $styles = [];

    public function __construct(string $name, array $data = null)
    {
        $this->name = $name;
        $this->data = $data;
    }

    /**
     * Subclass and override this function for custom widgets.
     */
    public function render(): string
    {
        $output = "Debug Mode<br>\n";
        foreach ($this->data as $key => $value) {
            $output .= "$key: " . var_export($value, true) . "<br>\n";
        }
        return $output;
    }

    public function setScript(string $name, string $src): void
    {
        $this->scripts[$name] = $src;
    }

    public function setStyle(string $name, string $href): void
    {
        $this->styles[$name] = $href;
    }

    public function getName()
    {
        return $this->content;
    }

    public function getScripts()
    {
        return $this->scripts;
    }

    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * You can add content directly to $content but should call this function instead.
     */
    protected function addDiv(string $divContent): void
    {
        $this->content .= "<div>$divContent</div>\n";
    }
}
