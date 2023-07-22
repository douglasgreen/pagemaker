<?php

namespace PageMakerDev;

use PageMakerDev\Widget\Widget;

/*
 * @class Page body builder
 */
class Body
{
    /**
     * Add a widget to the top-level part.
     */
    public function addWidget(string $partClass, Widget $widget): void
    {
        if (!isset($this->widgets[$partClass])) {
            throw new LibraryException('Bad top-level container');
        }

        $this->widgets[$partClass][] = $widget;
    }

    public function render(): string
    {
        $output = "<body class='pmBody'>\n";
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
            throw new LibraryException('Bad container class');
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

        $output .= "</$tag>\n";
        return $output;
    }
}
