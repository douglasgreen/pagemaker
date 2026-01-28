<?php
namespace App\Layout\Components;

use App\Layout\Breakpoint;
use App\Layout\MenuStyle;
use App\Layout\Renderable;

class Header implements Renderable {
    private ?Menu $menu = null;
    private ?SearchForm $search = null;
    private $brand = null; // string|array [text, url]
    private Breakpoint $expandBreakpoint = Breakpoint::LG;
    private bool $hasOffcanvasToggle = false;
    private string $offcanvasTarget = '';
    
    public function setBrand(string $text, string $url = '/'): self {
        $this->brand = ['text' => $text, 'url' => $url];
        return $this;
    }
    
    public function setMenu(Menu $menu): self {
        $this->menu = $menu;
        return $this;
    }
    
    public function setSearchForm(SearchForm $form): self {
        $this->search = $form;
        return $this;
    }
    
    public function setExpandBreakpoint(Breakpoint $bp): self {
        $this->expandBreakpoint = $bp;
        return $this;
    }
    
    // Used by Page when using OFFCANVAS layout
    public function enableOffcanvasToggle(string $targetId): self {
        $this->hasOffcanvasToggle = true;
        $this->offcanvasTarget = $targetId;
        return $this;
    }
    
    public function render(): string {
        $bp = $this->expandBreakpoint->value;
        $classes = "navbar navbar-expand-{$bp} navbar-dark bg-dark";
        
        ob_start();
        ?>
        <header>
            <nav class="<?= $classes ?>">
                <div class="container-fluid">
                    <?php if ($this->hasOffcanvasToggle): ?>
                    <button class="navbar-toggler d-<?= $bp ?>-none me-2" type="button" 
                            data-bs-toggle="offcanvas" data-bs-target="#<?= $this->offcanvasTarget ?>">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <?php endif; ?>
                    
                    <?php if ($this->brand): ?>
                    <a class="navbar-brand" href="<?= htmlspecialchars($this->brand['url']) ?>">
                        <?= htmlspecialchars($this->brand['text']) ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($this->menu || $this->search): ?>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#navbarContent" aria-controls="navbarContent" 
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <?php if ($this->menu): ?>
                            <?= $this->menu->setStyle(MenuStyle::NAVBAR)->render() ?>
                        <?php endif; ?>
                        
                        <?php if ($this->search): ?>
                            <div class="d-flex ms-auto">
                                <?= $this->search->render() ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </nav>
        </header>
        <?php
        return ob_get_clean();
    }
}
