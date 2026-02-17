<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Components\Breadcrumb;
use DouglasGreen\PageMaker\Enums\Breakpoint;
use DouglasGreen\PageMaker\Enums\LayoutPattern;

$page = createPage('Partially Collapsing Layout - PageMaker Demo', $renderer);

$page->setLayout(LayoutPattern::PARTIALLY_COLLAPSING, Breakpoint::LG);
$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Layouts' => '/layouts/',
    'Partially Collapsing' => null,
]));

$page->setLeftSidebar(createSidebar());

$page->setMainContent(<<<'HTML'
<div class="p-4">
    <h1>Partially Collapsing Layout</h1>
    <p class="lead">Sidebar narrows to icons on mobile, expands on hover.</p>
    
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Behavior:</strong> On mobile, only icons are visible. Hover (or tap) the sidebar 
        to expand it and reveal the labels. The sidebar is always visible.
    </div>
    
    <h3>Features</h3>
    <ul>
        <li>Sidebar always visible (never hidden)</li>
        <li>Icon-only mode saves space on mobile</li>
        <li>Smooth hover expansion</li>
        <li>No offcanvas overlay needed</li>
    </ul>
    
    <h3>Configuration</h3>
    <pre class="bg-light p-3 rounded"><code>$page->setLayout(LayoutPattern::PARTIALLY_COLLAPSING, Breakpoint::LG);</code></pre>
    
    <h3>Interaction Tips</h3>
    <div class="row g-3 mt-3">
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-hand-index me-2"></i>Desktop</h5>
                    <p class="card-text">Hover over the sidebar to expand it and see labels.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-hand-index-thumb me-2"></i>Mobile</h5>
                    <p class="card-text">Tap on the sidebar area to expand it.</p>
                </div>
            </div>
        </div>
    </div>
</div>
HTML);

echo $page->render();
