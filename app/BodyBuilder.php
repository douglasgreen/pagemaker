<?php

namespace PageMaker;

/**
 * @Todo Add same styles to HtmlBuilder
 * @todo Add Section builder using width/div/flex for each section.
 */
class BodyBuilder {
    protected $tags = [
        'pmHeader' => [],
        'pmLeftNav' => [],
        'pmMain' => [],
        'pmRightNav' => [],
        'pmFooter' => [],
    ];

    /**
     * @todo Throw exception on dupe section ID
     */
    public function addSection(string $partId, string $sectionId, string $content): void {
        $this->tags[$partId][$sectionId] = $content;
    }

    public function render() {
        extract($this->tags);
        $html = "<body id='pmBody'>";
        $html .= "<header id='pmHeader'>";
        foreach ($pmHeader as $sectionId => $content) {
            $html .= "<section id='$sectionId'>$content</section>";
        }
        $html .= "</header>";
        if ($pmLeftNav) {
            $html .= "<nav id='pmLeftNav'>";
            foreach ($pmLeftNav as $sectionId => $content) {
                $html .= "<section id='$sectionId'>$content</section>";
            }
            $html .= "</nav>";
        }
        $html .= "<main id='pmMain'>";
        foreach ($pmMain as $sectionId => $content) {
            $html .= "<section id='$sectionId'>$content</section>";
        }
        $html .= '</main>';
        if ($pmRightNav) {
            $html .= "<nav id='pmRightNav'>";
            foreach ($pmRightNav as $sectionId => $content) {
                $html .= "<section id='$sectionId'>$content</section>";
            }
            $html .= "</nav>";
        }
        $html .= "<footer id='pmFooter'>";
        foreach ($pmFooter as $sectionId => $content) {
            $html .= "<section id='$sectionId'>$content</section>";
        }
        $html .= "</footer>";

        return $html;
    }
}

