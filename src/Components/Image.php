<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Renderable;

/**
 * Responsive image component with CLS prevention.
 */
class Image implements Renderable
{
    public function __construct(
        private readonly string $src,
        private readonly string $alt,
        private readonly int $width,
        private readonly int $height,
        private readonly ?string $srcset = null,
        private readonly ?string $sizes = null,
        private readonly bool $lazy = true,
        private readonly string $class = 'img-fluid',
    ) {}

    public function render(): string
    {
        $attrs = [
            'src' => htmlspecialchars($this->src, ENT_QUOTES, 'UTF-8'),
            'alt' => htmlspecialchars($this->alt, ENT_QUOTES, 'UTF-8'),
            'width' => (string) $this->width,
            'height' => (string) $this->height,
            'class' => $this->class,
        ];

        if ($this->srcset) {
            $attrs['srcset'] = $this->srcset;
        }

        if ($this->sizes) {
            $attrs['sizes'] = $this->sizes;
        }

        if ($this->lazy) {
            $attrs['loading'] = 'lazy';
            $attrs['decoding'] = 'async';
        }

        $attrString = implode(' ', array_map(
            fn (string $k, string $v): string => sprintf('%s="%s"', $k, $v),
            array_keys($attrs),
            $attrs,
        ));

        return sprintf('<img %s>', $attrString);
    }
}
