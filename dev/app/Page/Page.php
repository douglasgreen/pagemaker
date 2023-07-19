<?php

namespace PageMaker\Page;

use Exception;
use PageMaker\Widget\Widget;

/*
 * @class Page builder
 */
class Page
{
    /** @var string Character set */
    protected $charset = 'UTF-8';

    /** @var string Favicon */
    protected $favicon;

    /** @var string Language */
    protected $lang = 'en';

    /** @var array Page metadata */
    protected $metadata = [
        'http-equiv' => [
            'content-type' => null,
            'default-style' => null,
            'refresh' => null
        ],
        'name' => [
            'application-name' => null,
            'author' => null,
            'description' => null,
            'generator' => null,
            'keywords' => null
        ]
    ];

    /** @var array Top-level containers (parts) that hold widgets */
    protected $widgets = [
        'pmHeader' => [],
        'pmMain' => [],
        'pmFooter' => [],
    ];

    /** @var array Named script URLs */
    protected $scripts = [];

    /** @var array Named style URLs */
    protected $styles = [];

    /** @var string $title */
    protected $title;

    /** @var string Semantic version of this class and its CSS/JS files */
    protected $version = "0.1.0";

    /**
     * Set the page title.
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Add a widget to the top-level part.
     */
    public function addWidget(string $partClass, Widget $widget): void
    {
        if (!isset($this->widgets[$partClass])) {
            throw new Exception('Bad top-level container');
        }
        $this->widgets[$partClass][] = $widget;
    }

    public function setCharset(string $charset): void
    {
        $this->charset = $charset;
    }

    public function setFavicon(string $favicon): void
    {
        $this->favicon = $favicon;
    }

    public function setLanguage(string $lang): void
    {
        $this->lang = $lang;
    }

    public function setMeta(string $name, string $content): void
    {
        if (array_key_exists($this->metadata['http-equiv'], $name)) {
            $this->metadata['http-equiv'][$name] = $content;
            return;
        }
        if (array_key_exists($this->metadata['name'], $name)) {
            $this->metadata['name'][$name] = $content;
            return;
        }
        throw new Exception("Unrecognize meta name");
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

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function render(): string
    {
        $output = "<!DOCTYPE html>\n";
        $output .= "<html lang='$this->lang'>\n";
        $output .= "<head>\n";

        $output .= "<title>{$this->title}</title>\n";

        $output .= "<meta charset='$this->charset'>\n";

        foreach ($this->metadata as $type => $values) {
            foreach ($values as $name => $content) {
                if ($content !== null) {
                    $output .= "<meta $type='$name' content='$content'>\n";
                }
            }
        }

        if ($this->favicon) {
            $output .= "<link rel='icon' href='$this->favicon' type='image/x-icon'>";
        }

        foreach ($this->styles as $href) {
            $output .= "<link rel='stylesheet' type='text/css' href='{$href}'>\n";
        }

        foreach ($this->scripts as $src) {
            $output .= "<script src='{$src}'></script>\n";
        }

        $output .= "</head>\n";

        $output .= "<body class='pmBody'>\n";
        $output .= $this->renderSection('header', 'pmHeader');
        $output .= $this->renderSection('main', 'pmMain');
        $output .= $this->renderSection('footer', 'pmFooter');
        $output .= "</body>\n";
        $output .= "</html>\n";

        return $output;
    }

    protected function renderSection(string $tag, string $partClass): string
    {
        if (!$this->widgets[$partClass]) {
            throw new Exception('Bad container class');
        }
        $output = "<$tag class='$partClass'>\n";
        foreach ($this->widgets[$partClass] as $widget) {
            $widgetTag = $widget->getTag();
            $widgetClass = $widget->getClass();
            $output .= "<$widgetTag class='$widgetClass'>\n";

            // @todo What if the widgets have conflicting requirements with the main page?
            foreach ($widget->getScripts() as $name => $script) {
                $this->setScript($name, $script);
            }
            foreach ($widget->getStyles() as $name => $style) {
                $this->setStyle($name, $style);
            }
            try {
                $content = $widget->render();
            } catch (Throwable $e) {
                $content = '<p style="color: red">Error rendering ' . $widget->getName() . '</p>';
            }
                $output .= "</$widgetTag>\n";
        }
    }
        $output .= "</$tag>\n";
        return $output;
}
}
