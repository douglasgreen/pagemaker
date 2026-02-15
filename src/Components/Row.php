<?php

declare(strict_types=1);

namespace App\Layout\Components;

use App\Layout\Breakpoint;
use App\Layout\Renderable;

class Row implements Renderable
{
    /** @var array<int, array{width: int, content: Renderable|string, breakpoint: Breakpoint|null}> */
    private array $columns = [];

    private string $classes = '';

    public function addColumn(int $width, Renderable|string $content, ?Breakpoint $breakpoint = null): self
    {
        $this->columns[] = [
            'width' => $width,
            'content' => $content,
            'breakpoint' => $breakpoint,
        ];
        return $this;
    }

    public function setClasses(string $classes): self
    {
        $this->classes = $classes;
        return $this;
    }

    public function render(): string
    {
        $html = '<div class="row ' . $this->classes . '">';
        foreach ($this->columns as $col) {
            $bp = $col['breakpoint']?->value;
            $class = $bp ? sprintf('col-%s-%s', $bp, $col['width']) : 'col-' . $col['width'];
            $content = $col['content'] instanceof Renderable
                ? $col['content']->render()
                : $col['content'];
            $html .= sprintf('<div class="%s mb-3">%s</div>', $class, $content);
        }

        return $html . '</div>';
    }
}
