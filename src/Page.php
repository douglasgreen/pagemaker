<?php

namespace PageMaker;

class Page
{
    protected $title;
    protected $metadata = [];
    protected $styleUrls = [];
    protected $scriptUrls = [];
    protected $inlineStyles = [];
    protected $inlineScripts = [];
    protected $body = '';

    public function setTitle($title)
    {
        $this->title = $title;
    }

    /** @todo Replace with mandatory template? */
    public function addBody($content)
    {
        $this->body .= $content;
    }

    public function addMeta($name, $content)
    {
        $this->metadata[] = [
            'name' => $name,
            'content' => $content,
        ];
    }

    public function addStyleClass($class, $cssProperties)
    {
        $class = '.' . ltrim($class, '.');
        if (isset($this->inlineStyles[$class])) {
            throw new Exception("Duplicate class");
        }
        $this->inlineStyles[$class] = $cssProperties;
    }

    public function addStyleId($id, $cssProperties)
    {
        $id = '#' . ltrim($id, '#');
        if (isset($this->inlineStyles[$id])) {
            throw new Exception("Duplicate id");
        }
        $this->inlineStyles[$id] = $cssProperties;
    }

    public function addScriptClass($class, $event, $function)
    {
        $class = '.' . ltrim($class, '.');
        if (isset($this->inlineScripts[$class][$event])) {
            throw new Exception("Duplicate class");
        }
        $this->inlineScripts[$class][$event] = $function;
    }

    public function addScriptId($id, $event, $function)
    {
        $id = '#' . ltrim($id, '#');
        if (isset($this->inlineScripts[$id][$event])) {
            throw new Exception("Duplicate id");
        }
        $this->inlineScripts[$id][$event] = $function;
    }

    public function addStyleUrl($href)
    {
        $this->styleUrls[] = $href;
    }

    public function addScript($src)
    {
        $this->scriptUrls[] = $src;
    }

    public function render()
    {
        echo "<!DOCTYPE html>\n";
        echo "<html>\n";
        echo "<head>\n";
        echo "<title>{$this->title}</title>\n";
        foreach ($this->metadata as $meta) {
            echo "<meta name='{$meta['name']}' content='{$meta['content']}'>\n";
        }
        foreach ($this->styleUrls as $href) {
            echo "<link rel='stylesheet' type='text/css' href='{$href}'>\n";
        }
        if ($this->inlineStyles) {
            echo "<style>\n";
            foreach ($this->inlineStyles as $selector => $properties) {
                echo "{$selector} {\n";
                echo "  {$properties}\n";
                echo "}\n";
            }
            echo "</style>\n";
        }
        echo "</head>\n";
        echo "<body>\n";
        echo $this->body;
        foreach ($this->scriptUrls as $src) {
            echo "<script src='{$src}'></script>\n";
        }
        foreach ($this->inlineScripts as $selector => $functions) {
            foreach ($functions as $event => $function) {
                 echo "\$('{$selector}').on('$event', $function\n";
            }
        }
        echo "</body>\n";
        echo "</html>\n";
    }
}
