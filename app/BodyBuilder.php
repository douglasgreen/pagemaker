<?php

namespace PageMaker;

/**
 * @Todo Add same styles to HtmlBuilder
 * @todo Add Section builder using width/div/flex for each section.
 */
class BodyBuilder {
    protected $tags = [
        'pmLogo' => null,
        'pmSearch' => null,
        'pmIconBar' => null,
        'pmMenu' => null,
        'pmLeftNav' => null,
        'pmSections' => [],
        'pmRightNav' => null,
        'pmFooter' => null,
    ];

    public function setLogo(string $content): void {
        $this->tags['pmLogo'] = $content;
    }

    public function setSearch(string $content): void {
        $this->tags['pmSearch'] = $content;
    }

    public function setIconBar(string $content): void {
        $this->tags['pmIconBar'] = $content;
    }

    public function setMenu(string $content): void {
        $this->tags['pmMenu'] = $content;
    }

    public function setLeftNav(string $content): void {
        $this->tags['pmLeftNav'] = $content;
    }

    public function addSection(string $id, string $content): void {
        $this->tags['pmSections'][$id] = $content;
    }

    public function setRightNav(string $content): void {
        $this->tags['pmRightNav'] = $content;
    }

    public function setFooter(string $content): void {
        $this->tags['pmFooter'] = $content;
    }

    public function render() {
        extract($this->tags);
        $html = "<body id='pmBody'>";
        if ($pmLogo || $pmSearch || $pmIconBar || $pmMenu) {
            $html .= "<header id='pmHeader'>";
            if ($pmLogo || $pmSearch || $pmIconBar) {
                $html .= "<div id='pmBanner'>";
                if ($pmLogo) {
                    $html .= "<div id='pmLogo'>{$pmLogo}</div>";
                }
                if ($pmSearch) {
                    $html .= "<div id='pmSearch'>{$pmSearch}</div>";
                }
                if ($pmIconBar) {
                    $html .= "<div id='pmIconBar'>{$pmIconBar}</div>";
                }
                $html .= "</div>";
            }
            if ($pmMenu) {
                $html .= "<nav id='pmMenu'>{$pmMenu}</nav>";
            }
            $html .= "</header>";
        }
        if ($pmLeftNav) {
            $html .= "<nav id='pmLeftNav'>{$pmLeftNav}</nav>";
        }
        $html .= "<main id='pmMain'>";
        foreach ($pmSections as $id => $section) {
            $html .= "<section id='$id'>{$section}</section>";
        }
        $html .= '</main>';
        if ($pmRightNav) {
            $html .= "<nav id='pmRightNav'>{$pmRightNav}</nav>";
        }
        if ($pmFooter) {
            $html .= "<footer id='pmFooter'>{$pmFooter}</footer>";
        }
        $html .= "</body>";

        return $html;
    }
}

