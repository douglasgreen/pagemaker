<?php

namespace PageMaker;

/**
 * A widget extends this class. It adds scripts, add styles, and output.
 */
class Widget
{
    protected $data;
    protected $name;
    protected $inlineScripts = [];
    protected $inlineStyles = [];
    protected $scripts = [];
    protected $styles = [];

    public function __construct(string $name, ?array $data)
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

    /** @todo Support inlines in Page. How to select JS? */
    public function addInlineScript(string $script): void
    {
        $this->inlineScripts[] = $script;
    }

    public function addInlineStyle(string $style): void
    {
        $this->inlineStyles[] = $style;
    }

    public function setScript(string $name, string $src): void
    {
        $this->scripts[$name] = $src;
    }

    public function setStyle(string $name, string $href): void
    {
        $this->styles[$name] = $href;
    }

    public function getName() {
        return $this->content;
    }

    public function getScripts() {
        return $this->scripts;
    }

    public function getStyles() {
        return $this->styles;
    }
}
