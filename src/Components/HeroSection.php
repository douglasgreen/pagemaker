<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Contracts\Renderable;

/**
 * Hero section component (jumbotron pattern).
 */
class HeroSection implements Renderable
{
    protected string $template = 'components/hero.html.twig';

    public function __construct(
        private readonly string $title,
        private readonly string $subtitle = '',
        private readonly ?string $ctaLabel = null,
        private readonly ?string $ctaUrl = null,
        private readonly ?string $backgroundImage = null,
        private readonly string $theme = 'dark',   // 'dark' overlay | 'light'
    ) {}

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
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'cta_label' => $this->ctaLabel,
            'cta_url' => $this->ctaUrl,
            'background_image' => $this->backgroundImage,
            'theme' => $this->theme,
        ];
    }
}
