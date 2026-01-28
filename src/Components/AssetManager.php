<?php
namespace App\Layout\Components;

// Asset Manager
class AssetManager {
    private array $css = [];
    private array $js = ['head' => [], 'body' => []];
    
    public function addCSS(string $source, bool $inline = false, array $attrs = []): void {
        $this->css[] = compact('source', 'inline', 'attrs');
    }
    
    public function addJS(string $source, string $position, bool $inline = false, array $attrs = []): void {
        $this->js[$position][] = compact('source', 'inline', 'attrs');
    }
    
    public function renderCSS(): string {
        $html = '';
        foreach ($this->css as $asset) {
            if ($asset['inline']) {
                $html .= '<style>' . $asset['source'] . '</style>';
            } else {
                $attrs = $this->attrsToString($asset['attrs']);
                $html .= sprintf('<link href="%s" rel="stylesheet"%s>', 
                    htmlspecialchars($asset['source']), $attrs);
            }
        }
        return $html;
    }
    
    public function renderJS(string $position): string {
        $html = '';
        foreach ($this->js[$position] as $asset) {
            if ($asset['inline']) {
                $html .= '<script>' . $asset['source'] . '</script>';
            } else {
                $attrs = $this->attrsToString($asset['attrs']);
                $html .= sprintf('<script src="%s"%s></script>', 
                    htmlspecialchars($asset['source']), $attrs);
            }
        }
        return $html;
    }
    
    private function attrsToString(array $attrs): string {
        $str = '';
        foreach ($attrs as $k => $v) {
            $str .= ' ' . $k . '="' . htmlspecialchars($v) . '"';
        }
        return $str;
    }
}
