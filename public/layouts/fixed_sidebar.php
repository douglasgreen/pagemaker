<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Components\Breadcrumb;
use DouglasGreen\PageMaker\Enums\Breakpoint;
use DouglasGreen\PageMaker\Enums\LayoutPattern;

$page = createPage('Fixed Sidebar Layout - PageMaker Demo', $renderer);

$page->setLayout(LayoutPattern::FIXED_SIDEBAR, Breakpoint::LG);
$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Layouts' => '/layouts/',
    'Fixed Sidebar' => null,
]));

$page->setLeftSidebar(createSidebar());

$page->setMainContent(<<<'HTML'
<div class="p-4">
    <h1>Fixed Sidebar Layout</h1>
    <p class="lead">Fixed-position sidebar with independent scrolling.</p>
    
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Behavior:</strong> The sidebar stays fixed on screen while the main content scrolls.
        On mobile, it collapses to a narrow icon strip.
    </div>
    
    <h3>Features</h3>
    <ul>
        <li>Sidebar always visible</li>
        <li>Independent scroll regions</li>
        <li>Mini mode on mobile (icons only)</li>
        <li>Great for dashboards and apps</li>
    </ul>
    
    <h3>Configuration</h3>
    <pre class="bg-light p-3 rounded"><code>$page->setLayout(LayoutPattern::FIXED_SIDEBAR, Breakpoint::LG);</code></pre>
    
    <h3>Scroll Demo</h3>
    <p>Scroll down to see the sidebar stay fixed while this content scrolls.</p>
    
    <div class="mt-4">
        <div class="card mb-3"><div class="card-body"><h5>Section 1</h5><p>Content to demonstrate fixed sidebar scrolling behavior.</p></div></div>
        <div class="card mb-3"><div class="card-body"><h5>Section 2</h5><p>Notice how the sidebar stays in place as you scroll.</p></div></div>
        <div class="card mb-3"><div class="card-body"><h5>Section 3</h5><p>Independent scrolling for sidebar and main content.</p></div></div>
        <div class="card mb-3"><div class="card-body"><h5>Section 4</h5><p>Great for dashboards with navigation.</p></div></div>
        <div class="card mb-3"><div class="card-body"><h5>Section 5</h5><p>Mobile users see an icon-only strip.</p></div></div>
    </div>
</div>
HTML);

echo $page->render();
