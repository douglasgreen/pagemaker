<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker\Components;

use InvalidArgumentException;

// Asset Manager
class AssetManager
{
    /** @var array<int, array{source: string, inline: bool, attrs: array<string, string>}> */
    private array $css = [];

    /** @var array{head: array<int, array{source: string, inline: bool, attrs: array<string, string>}>, body: array<int, array{source: string, inline: bool, attrs: array<string, string>}>} */
    private array $js = ['head' => [], 'body' => []];

    private ?string $cspNonce = null;

    public function setCspNonce(string $nonce): void
    {
        $this->cspNonce = $nonce;
    }

    /**
     * @param array<string, string> $attrs
     */
    public function addCSS(string $source, bool $inline = false, array $attrs = []): void
    {
        $this->css[] = ['source' => $source, 'inline' => $inline, 'attrs' => $attrs];
    }

    /**
     * @param array<string, string> $attrs
     */
    public function addJS(string $source, string $position, bool $inline = false, array $attrs = []): void
    {
        // Validate position to ensure it matches the strict array shape keys ('head', 'body')
        if (!in_array($position, ['head', 'body'], true)) {
            throw new InvalidArgumentException(sprintf('Invalid JS position: %s. Allowed: head, body.', $position));
        }

        $this->js[$position][] = ['source' => $source, 'inline' => $inline, 'attrs' => $attrs];
    }

    public function renderCSS(): string
    {
        $html = '';
        foreach ($this->css as $asset) {
            if ($asset['inline']) {
                $nonce = $this->cspNonce ? ' nonce="' . htmlspecialchars($this->cspNonce, ENT_QUOTES, 'UTF-8') . '"' : '';
                $html .= '<style' . $nonce . '>' . $asset['source'] . '</style>';
            } else {
                $attrs = $this->attrsToString($asset['attrs']);
                $html .= sprintf(
                    '<link href="%s" rel="stylesheet"%s>',
                    htmlspecialchars((string) $asset['source']),
                    $attrs,
                );
            }
        }

        return $html;
    }

    public function renderJS(string $position): string
    {
        $html = '';
        if (!isset($this->js[$position])) {
            return $html;
        }

        foreach ($this->js[$position] as $asset) {
            if ($asset['inline']) {
                $nonce = $this->cspNonce ? ' nonce="' . htmlspecialchars($this->cspNonce, ENT_QUOTES, 'UTF-8') . '"' : '';
                $html .= '<script' . $nonce . '>' . $asset['source'] . '</script>';
            } else {
                $attrs = $this->attrsToString($asset['attrs']);
                $html .= sprintf(
                    '<script src="%s"%s></script>',
                    htmlspecialchars((string) $asset['source']),
                    $attrs,
                );
            }
        }

        return $html;
    }

    /**
     * @param array<string, string> $attrs
     */
    private function attrsToString(array $attrs): string
    {
        $str = '';
        foreach ($attrs as $k => $v) {
            $str .= ' ' . $k . '="' . htmlspecialchars((string) $v) . '"';
        }

        return $str;
    }
}
