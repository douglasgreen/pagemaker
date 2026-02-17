<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Components\Breadcrumb;
use DouglasGreen\PageMaker\Enums\Breakpoint;
use DouglasGreen\PageMaker\Enums\LayoutPattern;

$page = createPage('Mini Icon Sidebar Layout - PageMaker Demo', $renderer);

$page->setLayout(LayoutPattern::MINI_ICON_SIDEBAR, Breakpoint::LG);
$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Layouts' => '/layouts/',
    'Mini Icon Sidebar' => null,
]));

$page->setLeftSidebar(createSidebar());

$page->setMainContent(<<<'HTML'
<div class="p-4">
    <h1>Mini Icon Sidebar Layout</h1>
    <p class="lead">Narrow icon strip always visible, expands on hover/tap.</p>
    
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Behavior:</strong> A narrow icon strip is always visible. On mobile, only icons show.
        At the breakpoint (or on hover), text labels appear beside the icons.
    </div>
    
    <h3>Features</h3>
    <ul>
        <li>Always-visible icon strip</li>
        <li>Minimal space usage</li>
        <li>Expand on hover for labels</li>
        <li>Great for tool-based UIs</li>
    </ul>
    
    <h3>Configuration</h3>
    <pre class="bg-light p-3 rounded"><code>$page->setLayout(LayoutPattern::MINI_ICON_SIDEBAR, Breakpoint::LG);</code></pre>
    
    <h3>Use Cases</h3>
    <div class="row g-3 mt-3">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-code-slash display-4 text-primary"></i>
                    <h5 class="card-title mt-2">IDEs</h5>
                    <p class="card-text small">Code editors with tool panels</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-brush display-4 text-primary"></i>
                    <h5 class="card-title mt-2">Design Tools</h5>
                    <p class="card-text small">Figma-like interfaces</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-terminal display-4 text-primary"></i>
                    <h5 class="card-title mt-2">Admin Panels</h5>
                    <p class="card-text small">Dashboard navigation</p>
                </div>
            </div>
        </div>
    </div>
    
    <p class="mt-4">Hover over the sidebar icons to see them expand with labels.</p>
</div>
HTML);

echo $page->render();
