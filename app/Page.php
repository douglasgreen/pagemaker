<?php

namespace PageMaker;

use Exception;
use PageMaker\Widgets\Widget;

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

    /** @var array Top-level containers */
    protected $containers = [
        'pmHeader' => [],
        'pmNav' => [],
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
     * Sections are organized by top-level container ID and section class.
     */
    public function addContainer(string $partId, Container $container): void
    {
        if (!isset($this->containers[$partId])) {
            throw new Exception('Bad top-level container');
        }
        $this->containers[$partId][] = $container;
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

        $output .= "<body id='pmBody'>\n";
        $output .= $this->renderSection('header', 'pmHeader');
        $output .= $this->renderSection('nav', 'pmNav');
        $output .= $this->renderSection('main', 'pmMain');
        $output .= $this->renderSection('footer', 'pmFooter');
        $output .= "</body>\n";
        $output .= "</html>\n";

        return $output;
    }

    protected function renderSection(string $tag, string $partId): string
    {
        if (!$this->containers[$partId]) {
            throw new Exception('Bad part ID');
        }
        $output = "<$tag id='$partId'>\n";
        foreach ($this->containers[$partId] as $container) {
            $containerTag = $container->getTag();
            $containerClass = $container->getClass();
            $widgets = $container->getWidgets();
            $output .= "<$containerTag class='$containerClass'>\n";
            foreach ($widgets as $widget) {
                $output .= $this->addWidget($partId, $containerClass, $widget);
            }
            $output .= "</$containerTag>\n";
        }
        $output .= "</$tag>\n";
        return $output;
    }

    /**
     * Widgets are like containers but self-contained with JS and CSS.
     */
    protected function renderWidget(string $partId, string $sectionClass, Widget $widget): string
    {
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
        return $content . "\n";
    }
}
