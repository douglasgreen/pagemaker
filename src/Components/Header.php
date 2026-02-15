<?php

namespace DouglasGreen\PageMaker\Components;

use DouglasGreen\PageMaker\Breakpoint;
use DouglasGreen\PageMaker\MenuStyle;
use DouglasGreen\PageMaker\Renderable;

class Header implements Renderable
{
    private ?Menu $menu = null;

    private ?SearchForm $search = null;

    /** @var array{text: string, url: string}|null */
    private ?array $brand = null;

    private Breakpoint $expandBreakpoint = Breakpoint::LG;

    private bool $hasOffcanvasToggle = false;

    private string $offcanvasTarget = '';

    public function setBrand(string $text, string $url = '/'): self
    {
        $this->brand = ['text' => $text, 'url' => $url];
        return $this;
    }

    public function setMenu(Menu $menu): self
    {
        $this->menu = $menu;
        return $this;
    }

    public function setSearchForm(SearchForm $form): self
    {
        $this->search = $form;
        return $this;
    }

    public function setExpandBreakpoint(Breakpoint $bp): self
    {
        $this->expandBreakpoint = $bp;
        return $this;
    }

    // Used by Page when using OFFCANVAS layout
    public function enableOffcanvasToggle(string $targetId): self
    {
        $this->hasOffcanvasToggle = true;
        $this->offcanvasTarget = $targetId;
        return $this;
    }

    public function render(): string
    {
        $bp = $this->expandBreakpoint->value;
        $classes = sprintf('navbar navbar-expand-%s navbar-dark bg-dark', $bp);

        ob_start();
        ?>
        <header>
            <nav class="<?= $classes; ?>">
                <div class="container-fluid">
                    <?php if ($this->hasOffcanvasToggle): ?>
                    <button class="navbar-toggler d-<?= $bp; ?>-none me-2" type="button" 
                            data-bs-toggle="offcanvas" data-bs-target="#<?= $this->offcanvasTarget; ?>">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <?php endif; ?>
                    
                    <?php if ($this->brand !== null): ?>
                    <a class="navbar-brand" href="<?= htmlspecialchars($this->brand['url']); ?>">
                        <?= htmlspecialchars($this->brand['text']); ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($this->menu || $this->search): ?>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#navbarContent" aria-controls="navbarContent" 
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <?php if ($this->menu instanceof \DouglasGreen\PageMaker\Components\Menu): ?>
                            <?= $this->menu->setStyle(MenuStyle::NAVBAR)->render(); ?>
                        <?php endif; ?>
                        
                        <?php if ($this->search instanceof \DouglasGreen\PageMaker\Components\SearchForm): ?>
                            <div class="d-flex ms-auto">
                                <?= $this->search->render(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </nav>
        </header>
        <?php
        return ob_get_clean() ?: '';
    }
}
