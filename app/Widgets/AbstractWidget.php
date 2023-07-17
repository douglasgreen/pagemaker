<?php

namespace PageMaker\Widgets;

/**
 * A widget extends this class. It adds scripts, add styles, and output.
 * The purpose of widget architecture is separation of features and error checking
 * @todo Add section builder to add divs to section?
 */
abstract class AbstractWidget
{
    protected $data;
    protected $name;
    protected $scripts = [];
    protected $styles = [];

    /** @var string Semantic version of this class and its CSS/JS files */
    protected $version = "0.1.0";

    public function __construct(string $name, array $data = null)
    {
        $this->name = $name;
        $this->data = $data;
    }

    public function setScript(string $name, string $src): void
    {
        if (strpos($src, '?') === false) {
            $src .= '?version=' . $this->version;
        }
        $this->scripts[$name] = $src;
    }

    public function setStyle(string $name, string $href): void
    {
        if (strpos($href, '?') === false) {
            $href .= '?version=' . $this->version;
        }
        $this->styles[$name] = $href;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getScripts(): array
    {
        return $this->scripts;
    }

    public function getStyles(): array
    {
        return $this->styles;
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
}
