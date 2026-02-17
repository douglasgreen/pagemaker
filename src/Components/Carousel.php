<?php

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Carousel/slider component.
 */
class Carousel implements Renderable
{
    protected string $template = 'components/carousel.html.twig';

    /**
     * @param array<array{src:string, alt:string, caption?:string, description?:string}> $slides
     * @param bool                                                                       $controls   Show prev/next arrows
     * @param bool                                                                       $indicators Show dot indicators
     * @param bool                                                                       $fade       Use crossfade instead of slide
     * @param int                                                                        $interval   Auto-play interval in ms (0 = no auto-play)
     * @param string|null                                                                $id
     */
    public function __construct(
        private array $slides,
        private bool $controls = true,
        private bool $indicators = true,
        private bool $fade = false,
        private int $interval = 5000,
        private ?string $id = null,
    ) {
        $this->id ??= 'pm-carousel-' . bin2hex(random_bytes(4));
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
        return [
            'slides' => $this->slides,
            'controls' => $this->controls,
            'indicators' => $this->indicators,
            'fade' => $this->fade,
            'interval' => $this->interval,
            'id' => $this->id,
        ];
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
