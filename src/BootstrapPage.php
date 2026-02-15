<?php

namespace App\Layout;

use App\Layout\Components\AlertCollection;
use App\Layout\Components\AssetManager;

class BootstrapPage
{
    private ?Renderable $header = null;

    private $leftNav;   // string|Renderable|callable

    private $main;      // required

    private $rightNav;  // string|Renderable|callable

    private ?Renderable $footer = null;

    private LayoutType $layout = LayoutType::HOLY_GRAIL;

    private Breakpoint $sidebarBreakpoint = Breakpoint::LG;

    private array $columnWidths = ['left' => 2, 'main' => 8, 'right' => 2];

    private readonly AssetManager $assets;

    private readonly AlertCollection $alerts;

    public function __construct(
        private readonly string $title = 'Untitled',
        private readonly string $lang = 'en',
        private readonly string $charset = 'UTF-8',
    ) {
        $this->assets = new AssetManager();
        $this->alerts = new AlertCollection();
        $this->validateWidths();
    }

    // Fluent configuration
    public function setLayout(LayoutType $type, Breakpoint $breakpoint = Breakpoint::LG): self
    {
        $this->layout = $type;
        $this->sidebarBreakpoint = $breakpoint;
        return $this;
    }

    public function setColumnWidths(int $left, int $main, int $right): self
    {
        $this->columnWidths = ['left' => $left, 'main' => $main, 'right' => $right];
        $this->validateWidths();
        return $this;
    }

    public function setHeader(Renderable|string $header): self
    {
        $this->header = is_string($header) ? new RawHtml($header) : $header;
        return $this;
    }

    public function setLeftNav(Renderable|string|callable $content): self
    {
        $this->leftNav = $content;
        return $this;
    }

    public function setMain(Renderable|string|callable $content): self
    {
        $this->main = $content;
        return $this;
    }

    public function setRightNav(Renderable|string|callable $content): self
    {
        $this->rightNav = $content;
        return $this;
    }

    public function setFooter(Renderable|string $footer): self
    {
        $this->footer = is_string($footer) ? new RawHtml($footer) : $footer;
        return $this;
    }

    public function addAlert(string $message, string $type = 'danger', bool $dismissible = true): self
    {
        $this->alerts->add($message, $type, $dismissible);
        return $this;
    }

    // Asset management
    public function addExternalCSS(string $url, array $attributes = []): self
    {
        $this->assets->addCSS($url, false, $attributes);
        return $this;
    }

    public function addInlineCSS(string $css): self
    {
        $this->assets->addCSS($css, true);
        return $this;
    }

    public function addExternalJS(string $url, string $position = 'head', array $attributes = []): self
    {
        $this->assets->addJS($url, $position, false, $attributes);
        return $this;
    }

    public function addInlineJS(string $js, string $position = 'head'): self
    {
        $this->assets->addJS($js, $position, true);
        return $this;
    }

    // Rendering
    public function render(): string
    {
        if ($this->main === null) {
            throw new \RuntimeException('Main content is required');
        }

        $bp = $this->sidebarBreakpoint->value;

        ob_start();
        ?><!DOCTYPE html>
<html lang="<?= htmlspecialchars($this->lang); ?>">
<head>
    <meta charset="<?= htmlspecialchars($this->charset); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($this->title); ?></title>
    <?= $this->assets->renderCSS(); ?>
    <?= $this->assets->renderJS('head'); ?>
</head>
<body>
    <?php if (!$this->alerts->isEmpty()): ?>
    <div class="container-fluid px-0">
        <?= $this->alerts->render(); ?>
    </div>
    <?php endif; ?>
    
    <?php if ($this->header instanceof \App\Layout\Renderable): ?>
        <?= $this->header->render(); ?>
    <?php endif; ?>
    
    <?php match ($this->layout) {
        LayoutType::HOLY_GRAIL => $this->renderHolyGrail($bp),
        LayoutType::OFFCANVAS_LEFT => $this->renderOffcanvas($bp),
        LayoutType::STACKED => $this->renderStacked($bp),
    }; ?>
    
    <?php if ($this->footer instanceof \App\Layout\Renderable): ?>
        <?= $this->footer->render(); ?>
    <?php endif; ?>
    
    <?= $this->assets->renderJS('body'); ?>
</body>
</html><?php
        return ob_get_clean();
    }

    private function renderHolyGrail(string $bp): void
    {
        $w = $this->columnWidths;
        $mainClass = sprintf('col-12 col-%s-%s', $bp, $w['main']);

        // If sidebars exist, add responsive classes
        $leftClass = sprintf('col-%s-%s d-none d-%s-block', $bp, $w['left'], $bp);
        $rightClass = sprintf('col-%s-%s d-none d-%s-block', $bp, $w['right'], $bp);
        ?>
        <div class="container-fluid">
            <div class="row">
                <?php if ($this->leftNav): ?>
                <aside class="<?= $leftClass; ?> sidebar-left">
                    <?= $this->renderContent($this->leftNav); ?>
                </aside>
                <?php endif; ?>
                
                <main class="<?= $mainClass; ?>">
                    <?= $this->renderContent($this->main); ?>
                </main>
                
                <?php if ($this->rightNav): ?>
                <aside class="<?= $rightClass; ?> sidebar-right">
                    <?= $this->renderContent($this->rightNav); ?>
                </aside>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    private function renderOffcanvas(string $bp): void
    {
        $w = $this->columnWidths;
        // Left nav is 3 cols on desktop, offcanvas on mobile
        // Main takes remaining space
        $mainCols = 12 - ($this->leftNav ? $w['left'] : 0) - ($this->rightNav ? $w['right'] : 0);
        ?>
        <div class="container-fluid">
            <div class="row">
                <?php if ($this->leftNav): ?>
                <aside class="col-<?= $bp; ?>-<?= $w['left']; ?> p-0">
                    <div class="offcanvas-<?= $bp; ?> offcanvas-start" tabindex="-1" id="sidebarMenu">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title">Menu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" 
                                    data-bs-target="#sidebarMenu" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <?= $this->renderContent($this->leftNav); ?>
                        </div>
                    </div>
                </aside>
                <?php endif; ?>
                
                <main class="col-12 col-<?= $bp; ?>-<?= $mainCols; ?>">
                    <?= $this->renderContent($this->main); ?>
                </main>
                
                <?php if ($this->rightNav): ?>
                <aside class="col-<?= $bp; ?>-<?= $w['right']; ?> d-none d-<?= $bp; ?>-block">
                    <?= $this->renderContent($this->rightNav); ?>
                </aside>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    private function renderStacked(string $bp): void
    {
        $w = $this->columnWidths;
        // Source order: Main, Left, Right
        // Visual order on desktop: Left (1), Main (2), Right (3)
        ?>
        <div class="container-fluid">
            <div class="row">
                <main class="col-12 col-<?= $bp; ?>-<?= $w['main']; ?> order-<?= $bp; ?>-2">
                    <?= $this->renderContent($this->main); ?>
                </main>
                
                <?php if ($this->leftNav): ?>
                <aside class="col-12 col-<?= $bp; ?>-<?= $w['left']; ?> order-<?= $bp; ?>-1 mb-3 mb-<?= $bp; ?>-0">
                    <?= $this->renderContent($this->leftNav); ?>
                </aside>
                <?php endif; ?>
                
                <?php if ($this->rightNav): ?>
                <aside class="col-12 col-<?= $bp; ?>-<?= $w['right']; ?> order-<?= $bp; ?>-3 mt-3 mt-<?= $bp; ?>-0">
                    <?= $this->renderContent($this->rightNav); ?>
                </aside>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    private function renderContent($content): string
    {
        if ($content instanceof Renderable) {
            return $content->render();
        }
        if (is_callable($content)) {
            return ($content)();
        }
        return (string) $content;
    }

    private function validateWidths(): void
    {
        $sum = array_sum($this->columnWidths);
        if ($sum !== 12) {
            throw new \InvalidArgumentException('Column widths must sum to 12, got ' . $sum);
        }
    }
}
