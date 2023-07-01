<?php

namespace PageMaker;

use Exception;

/*
 * @todo Add Section builder using width/div/flex for each section.
 */
class Page
{
    /** @var string Character set */
    protected $charset = 'UTF-8';

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
    protected $scriptUrls = [];

    /** @var array Named style URLs */
    protected $styleUrls = [];

    /** @var string $title */
    protected $title;

    public function setCharset(string $charset): void
    {
        $this->charset = $charset;
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
        $this->scriptUrls[$name] = $src;
    }

    public function setStyle(string $name, string $href): void
    {
        $this->styleUrls[$name] = $href;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Sections are organized by top-level container ID and section class.
     */
    public function addSection(string $partId, string $sectionClass, string $content): void
    {
        $this->sections[$partId][$sectionClass] = $content;
    }

    public function render(): void
    {
        echo "<!DOCTYPE html>\n";
        echo "<html>\n";
        echo "<head>\n";

        echo "<title>{$this->title}</title>\n";

        echo "<meta charset='$this->charset'>\n";

        foreach ($this->metadata as $type => $values) {
            foreach ($values as $name => $content) {
                if ($content !== null) {
                    echo "<meta $type='$name' content='$content'>\n";
                }
            }
        }

        foreach ($this->styleUrls as $href) {
            echo "<link rel='stylesheet' type='text/css' href='{$href}'>\n";
        }

        foreach ($this->scriptUrls as $src) {
            echo "<script src='{$src}'></script>\n";
        }

        echo "</head>\n";

        extract($this->sections);

        echo "<body id='pmBody'>\n";

        if ($pmHeader) {
            echo "<header id='pmHeader'>\n";
            foreach ($pmHeader as $sectionClass => $content) {
                echo "<section class='$sectionClass'>$content</section>\n";
            }
            echo "</header>\n";
        }

        if ($pmLeftNav) {
            echo "<nav id='pmLeftNav'>\n";
            foreach ($pmLeftNav as $sectionClass => $content) {
                echo "<section class='$sectionClass'>$content</section>\n";
            }
            echo "</nav>\n";
        }

        echo "<main id='pmMain'>\n";
        foreach ($pmMain as $sectionClass => $content) {
            echo "<section class='$sectionClass'>$content</section>\n";
        }
        echo "</main>\n";

        if ($pmRightNav) {
            echo "<nav id='pmRightNav'>\n";
            foreach ($pmRightNav as $sectionClass => $content) {
                echo "<section class='$sectionClass'>$content</section>\n";
            }
            echo "</nav>\n";
        }

        if ($pmFooter) {
            echo "<footer id='pmFooter'>\n";
            foreach ($pmFooter as $sectionClass => $content) {
                echo "<section class='$sectionClass'>$content</section>\n";
            }
            echo "</footer>\n";
        }

        echo "</body>\n";
        echo "</html>\n";
    }
}
