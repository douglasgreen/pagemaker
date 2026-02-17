<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Components\Breadcrumb;
use DouglasGreen\PageMaker\Enums\Breakpoint;
use DouglasGreen\PageMaker\Enums\LayoutPattern;

$page = createPage('Overlay Drawer Layout - PageMaker Demo', $renderer);

$page->setLayout(LayoutPattern::OVERLAY_DRAWER, Breakpoint::LG);
$page->setColumnWidths(3, 9, 0);

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Layouts' => '/layouts/',
    'Overlay Drawer' => null,
]));

$page->setLeftSidebar(createSidebar());

$page->setMainContent(<<<'HTML'
<div class="p-4">
    <h1>Overlay Drawer Layout</h1>
    <p class="lead">Full-screen overlay drawer on mobile.</p>
    
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Behavior:</strong> On mobile, a full-screen overlay drawer covers the content with a backdrop.
        On desktop, the sidebar renders as a normal grid column.
    </div>
    
    <h3>Features</h3>
    <ul>
        <li>Full-screen overlay on mobile</li>
        <li>Backdrop darkens main content</li>
        <li>Maximum focus on navigation when open</li>
        <li>Standard sidebar on desktop</li>
    </ul>
    
    <h3>Configuration</h3>
    <pre class="bg-light p-3 rounded"><code>$page->setLayout(LayoutPattern::OVERLAY_DRAWER, Breakpoint::LG);
$page->setColumnWidths(3, 9, 0);</code></pre>
    
    <h3>Difference from Offcanvas</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr><th>Feature</th><th>Offcanvas</th><th>Overlay Drawer</th></tr>
        </thead>
        <tbody>
            <tr><td>Width on mobile</td><td>Partial</td><td>Full screen</td></tr>
            <tr><td>Backdrop</td><td>Yes</td><td>Yes</td></tr>
            <tr><td>Focus</td><td>Nav + content visible</td><td>Navigation only</td></tr>
        </tbody>
    </table>
    
    <p class="mt-4">Resize your browser below 992px and click the menu button to see the overlay drawer.</p>
</div>
HTML);

echo $page->render();
