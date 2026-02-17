<?php

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Tab set component using Bootstrap tabs/pills.
 */
class TabSet implements Renderable
{
    protected string $template = 'components/tabset.html.twig';

    /**
     * @param array<string, string|Renderable> $tabs label => content
     * @param string $style 'tabs'|'pills'
     * @param string $orientation 'horizontal'|'vertical'
     * @param string|null $id Unique ID prefix (auto-generated if null)
     */
    public function __construct(
        private array $tabs,
        private string $style = 'tabs',
        private string $orientation = 'horizontal',
        private ?string $id = null,
    ) {
        $this->id ??= 'pm-tabset-' . bin2hex(random_bytes(4));
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        return '';
    }

    /**
     * Get data for template rendering.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        // Resolve any Renderable objects in tabs
        $resolvedTabs = [];
        foreach ($this->tabs as $label => $content) {
            if ($content instanceof Renderable) {
                $resolvedTabs[$label] = $content->render();
            } else {
                $resolvedTabs[$label] = $content;
            }
        }

        return [
            'tabs' => $resolvedTabs,
            'style' => $this->style,
            'orientation' => $this->orientation,
            'id' => $this->id,
        ];
    }
}
