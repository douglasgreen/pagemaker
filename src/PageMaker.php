<?php

namespace DouglasGreen\PageMaker;

use DouglasGreen\PageMaker\Assets\AssetManager;
use DouglasGreen\PageMaker\Contracts\Renderable;
use DouglasGreen\PageMaker\Enums\AssetPosition;
use DouglasGreen\PageMaker\Enums\Breakpoint;
use DouglasGreen\PageMaker\Enums\LayoutPattern;
use InvalidArgumentException;

/**
 * Central builder for creating Bootstrap-based page layouts.
 */
class PageMaker
{
    // ── Metadata ──────────────────────────────────
    private string $title = '';
    private string $lang = 'en';
    private array $metaTags = [];
    private string $charset = 'UTF-8';
    private string $viewport = 'width=device-width, initial-scale=1';

    // ── Layout ────────────────────────────────────
    private LayoutPattern $pattern = LayoutPattern::HOLY_GRAIL;
    private Breakpoint $sidebarBreakpoint = Breakpoint::LG;
    private array $columnWidths = [3, 6, 3]; // [left, main, right]

    // ── Content slots ─────────────────────────────
    private string|Renderable|null $header = null;
    private string|Renderable|null $footer = null;
    private string|Renderable|null $leftSidebar = null;
    private string|Renderable|null $rightSidebar = null;
    private string|Renderable|null $mainContent = null;
    private string|Renderable|null $heroSection = null;
    private string|Renderable|null $breadcrumb = null;

    // ── Extras ────────────────────────────────────
    private string $bodyClass = '';
    private string $containerId = 'page-wrapper';
    private bool $fluidContainer = false;

    // ── Assets ────────────────────────────────────
    private AssetManager $assets;

    // ── Template engine callback ──────────────────
    /** @var callable(string $template, array $context): string */
    private $renderer;

    /**
     * @param callable(string $template, array $context): string $renderer
     *        A function that accepts a template name and context array,
     *        returning rendered HTML. Wrap your Twig call here.
     */
    public function __construct(callable $renderer)
    {
        $this->renderer = $renderer;
        $this->assets = new AssetManager();
    }

    // ━━ Metadata setters ━━━━━━━━━━━━━━━━━━━━━━━━━

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function setLang(string $lang): static
    {
        $this->lang = $lang;
        return $this;
    }

    public function setCharset(string $charset): static
    {
        $this->charset = $charset;
        return $this;
    }

    public function setViewport(string $viewport): static
    {
        $this->viewport = $viewport;
        return $this;
    }

    public function addMeta(string $name, string $content): static
    {
        $this->metaTags[$name] = $content;
        return $this;
    }

    // ━━ Layout setters ━━━━━━━━━━━━━━━━━━━━━━━━━━━

    public function setLayout(
        LayoutPattern $pattern,
        Breakpoint $sidebarBreakpoint = Breakpoint::LG
    ): static {
        $this->pattern = $pattern;
        $this->sidebarBreakpoint = $sidebarBreakpoint;
        return $this;
    }

    /**
     * Set Bootstrap grid column widths for [left, main, right].
     * Must sum to 12. For layouts without a particular sidebar,
     * pass 0 for that column.
     *
     * @param int $left  0–12
     * @param int $main  1–12
     * @param int $right 0–12
     *
     * @throws InvalidArgumentException
     */
    public function setColumnWidths(int $left, int $main, int $right): static
    {
        $sum = $left + $main + $right;
        if ($sum !== 12) {
            throw new InvalidArgumentException(
                "Column widths must sum to 12; got {$left}+{$main}+{$right}={$sum}."
            );
        }
        if ($main < 1) {
            throw new InvalidArgumentException(
                "Main column must be at least 1; got {$main}."
            );
        }
        $this->columnWidths = [$left, $main, $right];
        return $this;
    }

    /**
     * Apply a named column width preset.
     *
     * @throws InvalidArgumentException
     */
    public function usePreset(string $preset): static
    {
        return match ($preset) {
            'left-only' => $this->setColumnWidths(3, 9, 0),
            'right-only' => $this->setColumnWidths(0, 9, 3),
            'both-narrow' => $this->setColumnWidths(2, 8, 2),
            'both-wide' => $this->setColumnWidths(3, 6, 3),
            'both-unequal' => $this->setColumnWidths(3, 7, 2),
            'no-sidebars' => $this->setColumnWidths(0, 12, 0),
            default => throw new InvalidArgumentException("Unknown preset: {$preset}"),
        };
    }

    // ━━ Content setters ━━━━━━━━━━━━━━━━━━━━━━━━━━

    /**
     * @param string|Renderable|callable $content
     */
    public function setHeader(string|Renderable|null $content): static
    {
        $this->header = $content;
        return $this;
    }

    /**
     * @param string|Renderable|callable $content
     */
    public function setFooter(string|Renderable|null $content): static
    {
        $this->footer = $content;
        return $this;
    }

    /**
     * @param string|Renderable|callable $content
     */
    public function setLeftSidebar(string|Renderable|null $content): static
    {
        $this->leftSidebar = $content;
        return $this;
    }

    /**
     * @param string|Renderable|callable $content
     */
    public function setRightSidebar(string|Renderable|null $content): static
    {
        $this->rightSidebar = $content;
        return $this;
    }

    /**
     * @param string|Renderable|callable $content
     */
    public function setMainContent(string|Renderable|null $content): static
    {
        $this->mainContent = $content;
        return $this;
    }

    /**
     * @param string|Renderable|callable $content
     */
    public function setHeroSection(string|Renderable|null $content): static
    {
        $this->heroSection = $content;
        return $this;
    }

    /**
     * @param string|Renderable|callable $content
     */
    public function setBreadcrumb(string|Renderable|null $content): static
    {
        $this->breadcrumb = $content;
        return $this;
    }

    // ━━ Extras ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

    public function setBodyClass(string $class): static
    {
        $this->bodyClass = $class;
        return $this;
    }

    public function setContainerId(string $id): static
    {
        $this->containerId = $id;
        return $this;
    }

    public function useFluidContainer(bool $fluid = true): static
    {
        $this->fluidContainer = $fluid;
        return $this;
    }

    // ━━ Asset pass-through ━━━━━━━━━━━━━━━━━━━━━━━

    public function assets(): AssetManager
    {
        return $this->assets;
    }

    // ━━ Resolve & Render ━━━━━━━━━━━━━━━━━━━━━━━━━

    /**
     * Evaluate a content slot to a string.
     */
    private function resolve(string|Renderable|callable|null $slot): string
    {
        if ($slot === null) {
            return '';
        }
        if (is_string($slot)) {
            return $slot;
        }
        if ($slot instanceof Renderable) {
            return $slot->render();
        }
        if (is_callable($slot)) {
            $result = ($slot)();
            return $result instanceof Renderable ? $result->render() : (string) $result;
        }
        return '';
    }

    /**
     * Build the full template context array.
     *
     * @return array<string, mixed>
     */
    private function buildContext(): array
    {
        $bp = $this->sidebarBreakpoint;

        return [
            // Metadata
            'title' => $this->title,
            'lang' => $this->lang,
            'charset' => $this->charset,
            'viewport' => $this->viewport,
            'meta_tags' => $this->metaTags,

            // Layout
            'pattern' => $this->pattern->value,
            'breakpoint' => $bp->value,
            'breakpoint_infix' => $bp->infix(),
            'col_left' => $this->columnWidths[0],
            'col_main' => $this->columnWidths[1],
            'col_right' => $this->columnWidths[2],

            // Resolved content
            'header' => $this->resolve($this->header),
            'footer' => $this->resolve($this->footer),
            'left_sidebar' => $this->resolve($this->leftSidebar),
            'right_sidebar' => $this->resolve($this->rightSidebar),
            'main_content' => $this->resolve($this->mainContent),
            'hero_section' => $this->resolve($this->heroSection),
            'breadcrumb' => $this->resolve($this->breadcrumb),

            // Extras
            'body_class' => $this->bodyClass,
            'container_id' => $this->containerId,
            'fluid_container' => $this->fluidContainer,

            // Assets
            'head_assets' => $this->assets->render(AssetPosition::HEAD),
            'body_start_assets' => $this->assets->render(AssetPosition::BODY_START),
            'body_end_assets' => $this->assets->render(AssetPosition::BODY_END),
        ];
    }

    /**
     * Render the final HTML page.
     */
    public function render(): string
    {
        return ($this->renderer)(
            $this->pattern->templateName(),
            $this->buildContext()
        );
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
