<?php

namespace DouglasGreen\PageMaker\Assets;

use DouglasGreen\PageMaker\Enums\AssetPosition;

/**
 * Manages CSS and JavaScript assets for a page.
 */
class AssetManager
{
    /** @var array<string, array{type:string, position:AssetPosition, attributes:array<string, string>, content?:string}> */
    private array $assets = [];

    /**
     * Add a CSS stylesheet.
     *
     * @param array<string, string> $attributes
     */
    public function addCss(
        string $href,
        AssetPosition $position = AssetPosition::HEAD,
        array $attributes = [],
    ): static {
        $this->assets[$href] = [
            'type' => 'css',
            'position' => $position,
            'attributes' => $attributes,
        ];
        return $this;
    }

    /**
     * Add a JavaScript file.
     *
     * @param array<string, string> $attributes
     */
    public function addJs(
        string $src,
        AssetPosition $position = AssetPosition::BODY_END,
        array $attributes = [],
    ): static {
        $this->assets[$src] = [
            'type' => 'js',
            'position' => $position,
            'attributes' => $attributes,
        ];
        return $this;
    }

    /**
     * Add an inline style block.
     */
    public function addInlineCss(
        string $css,
        AssetPosition $position = AssetPosition::HEAD,
    ): static {
        $key = 'inline_css_' . md5($css);
        $this->assets[$key] = [
            'type' => 'inline_css',
            'content' => $css,
            'position' => $position,
            'attributes' => [],
        ];
        return $this;
    }

    /**
     * Add an inline script block.
     */
    public function addInlineJs(
        string $js,
        AssetPosition $position = AssetPosition::BODY_END,
    ): static {
        $key = 'inline_js_' . md5($js);
        $this->assets[$key] = [
            'type' => 'inline_js',
            'content' => $js,
            'position' => $position,
            'attributes' => [],
        ];
        return $this;
    }

    /**
     * Register Bootstrap 5.3 CDN assets.
     */
    public function addBootstrap(string $version = '5.3.3'): static
    {
        $this->addCss(
            "https://cdn.jsdelivr.net/npm/bootstrap@{$version}/dist/css/bootstrap.min.css",
            AssetPosition::HEAD,
            ['crossorigin' => 'anonymous'],
        );
        $this->addJs(
            "https://cdn.jsdelivr.net/npm/bootstrap@{$version}/dist/js/bootstrap.bundle.min.js",
            AssetPosition::BODY_END,
            ['crossorigin' => 'anonymous'],
        );
        return $this;
    }

    /**
     * Register Bootstrap Icons CDN.
     */
    public function addBootstrapIcons(string $version = '1.11.3'): static
    {
        $this->addCss(
            "https://cdn.jsdelivr.net/npm/bootstrap-icons@{$version}/font/bootstrap-icons.min.css",
            AssetPosition::HEAD,
        );
        return $this;
    }

    /**
     * Render all assets for a given position as HTML tags.
     */
    public function render(AssetPosition $position): string
    {
        $html = '';

        foreach ($this->assets as $key => $asset) {
            if ($asset['position'] !== $position) {
                continue;
            }

            $attrs = '';
            foreach ($asset['attributes'] as $name => $value) {
                $attrs .= ' ' . $name . '="' . htmlspecialchars($value, ENT_QUOTES) . '"';
            }

            $html .= match ($asset['type']) {
                'css' => "<link rel=\"stylesheet\" href=\"{$key}\"{$attrs}>\n",
                'js' => "<script src=\"{$key}\"{$attrs}></script>\n",
                'inline_css' => "<style>{$asset['content']}</style>\n",
                'inline_js' => "<script>{$asset['content']}</script>\n",
                default => '',
            };
        }

        return $html;
    }
}
