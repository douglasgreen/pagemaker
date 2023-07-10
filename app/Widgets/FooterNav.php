<?php

namespace PageMaker\Widgets;

/**
 * @class Footer navigation links
 * @todo Style columns with flex
// Usage
$footerNav = new FooterNav();

// Add links to the first column
$footerNav->addSection(1, 'Links');
$footerNav->addLink(1, 'Home', '/');
$footerNav->addLink(1, 'About Us', '/about');

// Add links to the second column
$footerNav->addLink(2, 'Contact', '/contact');
$footerNav->addLink(2, 'Privacy Policy', '/privacy');

// Add links to the third column
$footerNav->addLink(3, 'Terms and Conditions', '/terms');
$footerNav->addLink(3, 'Blog', '/blog');

$page->addWidget('pmFooter', 'footerNav', $footerNav);
*/
class FooterNav extends Widget {
    protected $columns = [];

    public function addHtml(string $column, string $name, string $html): void {
        $this->columns[$column][$name] = $html;
    }

    public function addLink(string $column, string $text, string $url): void {
        $link = "<a href='$url'>$text</a>";
        $this->columns[$column][$text] = $link;
    }

    public function addSection(string $column, string $text): void {
        $heading = "<h4>$text</h4>";
        $this->columns[$column][$text] = $heading;
    }

    public function render(): string {
        ksort($this->columns);
       
        $html = ''; 
        foreach ($this->columns as $name => $column) {
            $html .= '<div class="footer-column">';
            foreach ($column as $item) {
                $html .= $item . '<br>';
            }
            $html .= '</div>';
        }

        return $html;
    }
}
