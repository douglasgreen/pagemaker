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

    /** @var array IDs of top-level containers */
    protected $sections = [
        'pmHeader' => [],
        'pmLeftNav' => [],
        'pmMain' => [],
        'pmRightNav' => [],
        'pmFooter' => [],
    ];

    /** @var array Named script URLs */
    protected $scripts = [];

    /** @var array Named style URLs */
    protected $styles = [];

    /** @var string $title */
    protected $title;

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
    public function addSection(string $partId, string $sectionClass, string $content): void
    {
        $content = trim($content);
        if ($content) {
            $this->sections[$partId][$sectionClass][] = $content;
        }
    }

    /**
     * Widgets are like sections but self-contained with JS and CSS.
     */
    public function addWidget(string $partId, string $sectionClass, Widget $widget): void
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
        $this->addSection($partId, $sectionClass, $content);
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
        $this->scripts[$name] = $src;
    }

    public function setStyle(string $name, string $href): void
    {
        $this->styles[$name] = $href;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
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

        extract($this->sections);

        $output .= "<body id='pmBody'>\n";
        $output .= $this->renderSections('header', 'pmHeader');
        $output .= $this->renderSections('nav', 'pmLeftNav');
        $output .= $this->renderSections('main', 'pmMain');
        $output .= $this->renderSections('nav', 'pmRightNav');
        $output .= $this->renderSections('footer', 'pmFooter');
        $output .= "</body>\n";
        $output .= "</html>\n";

        return $output;
    }

    protected function renderSections(string $tag, string $partId): string
    {
        if (!$this->sections[$partId]) {
            return '';
        }
        $output = "<$tag id='$partId'>\n";
        foreach ($this->sections[$partId] as $sectionClass => $contents) {
            foreach ($contents as $content) {
                $output .= "<section class='$sectionClass'>$content</section>\n";
            }
        }
        $output .= "</header>\n";
        return $output;
    }
}
