<?php
namespace App\Layout\Components;

use App\Layout\Renderable;

class Footer implements Renderable {
    private array $rows = [];
    private string $classes = 'bg-light py-4 mt-auto border-top';
    
    public function setClasses(string $classes): self {
        $this->classes = $classes;
        return $this;
    }
    
    public function addRow(): Row {
        $row = new Row();
        $this->rows[] = $row;
        return $row;
    }
    
    public function render(): string {
        $html = '<footer class="' . $this->classes . '"><div class="container-fluid">';
        foreach ($this->rows as $row) {
            $html .= $row->render();
        }
        $html .= '</div></footer>';
        return $html;
    }
}
