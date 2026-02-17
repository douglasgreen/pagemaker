<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Enums\Breakpoint;
use DouglasGreen\PageMaker\Enums\LayoutPattern;

$page = createPage('Offcanvas Left Layout - PageMaker Demo', $renderer);

$page->setLayout(LayoutPattern::OFFCANVAS_LEFT, Breakpoint::LG);
$page->setColumnWidths(3, 9, 0);

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Layouts' => '/layouts/',
    'Offcanvas Left' => null,
]));

$page->setLeftSidebar(createSidebar());

$page->setMainContent(<<<'HTML'
<div class="p-4">
    <h1>Offcanvas Left Layout</h1>
    <p class="lead">Left sidebar slides in as a drawer on mobile.</p>
    
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Behavior:</strong> On mobile, click the "Menu" button to slide in the sidebar from the left.
        At the breakpoint, the sidebar becomes a permanent grid column.
    </div>
    
    <h3>Features</h3>
    <ul>
        <li>Mobile-friendly offcanvas drawer</li>
        <li>Smooth slide-in animation</li>
        <li>Ideal for admin dashboards and apps</li>
        <li>Backdrop overlay on mobile</li>
    </ul>
    
    <h3>Configuration</h3>
    <pre class="bg-light p-3 rounded"><code>$page->setLayout(LayoutPattern::OFFCANVAS_LEFT, Breakpoint::LG);
$page->setColumnWidths(3, 9, 0);</code></pre>
    
    <p class="mt-4">Try resizing your browser window below 992px to see the offcanvas behavior.</p>
</div>
HTML);

echo $page->render();
