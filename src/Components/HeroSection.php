<?php

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Hero section component (jumbotron pattern).
 */
class HeroSection implements Renderable
{
    protected string $template = 'components/hero.html.twig';

    public function __construct(
        private string $title,
        private string $subtitle = '',
        private ?string $ctaLabel = null,
        private ?string $ctaUrl = null,
        private ?string $backgroundImage = null,
        private string $theme = 'dark',   // 'dark' overlay | 'light'
    ) {}

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
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'cta_label' => $this->ctaLabel,
            'cta_url' => $this->ctaUrl,
            'background_image' => $this->backgroundImage,
            'theme' => $this->theme,
        ];
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
