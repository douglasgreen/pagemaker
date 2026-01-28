<?php
namespace App\Layout\Components;

use App\Layout\Breakpoint;
use App\Layout\Renderable;

class Row implements Renderable {
    private array $columns = [];
    private string $classes = '';
    
    public function addColumn(int $width, Renderable|string $content, ?Breakpoint $breakpoint = null): self {
        $this->columns[] = [
            'width' => $width,
            'content' => $content,
            'breakpoint' => $breakpoint
        ];
        return $this;
    }
    
    public function setClasses(string $classes): self {
        $this->classes = $classes;
        return $this;
    }
    
    public function render(): string {
        $html = '<div class="row ' . $this->classes . '">';
        foreach ($this->columns as $col) {
            $bp = $col['breakpoint']?->value;
            $class = $bp ? "col-{$bp}-{$col['width']}" : "col-{$col['width']}";
            $content = $col['content'] instanceof Renderable 
                ? $col['content']->render() 
                : $col['content'];
            $html .= "<div class=\"{$class} mb-3\">{$content}</div>";
        }
        $html .= '</div>';
        return $html;
    }
}
