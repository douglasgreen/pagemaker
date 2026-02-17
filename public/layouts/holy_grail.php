<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Components\Breadcrumb;
use DouglasGreen\PageMaker\Components\Sidebar;
use DouglasGreen\PageMaker\Enums\Breakpoint;
use DouglasGreen\PageMaker\Enums\LayoutPattern;

$page = createPage('Holy Grail Layout - PageMaker Demo', $renderer);

$page->setLayout(LayoutPattern::HOLY_GRAIL, Breakpoint::LG);
$page->setColumnWidths(3, 6, 3);

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Layouts' => '/layouts/',
    'Holy Grail' => null,
]));

$page->setLeftSidebar(createSidebar());

$page->setRightSidebar(new Sidebar(
    navItems: [
        ['icon' => 'bell', 'label' => 'Notifications', 'href' => '#'],
        ['icon' => 'chat', 'label' => 'Messages', 'href' => '#'],
        ['icon' => 'bookmark', 'label' => 'Bookmarks', 'href' => '#'],
    ],
    heading: 'Quick Links',
));

$page->setMainContent(<<<'HTML'
<div class="p-4">
    <h1>Holy Grail Layout</h1>
    <p class="lead">The classic three-column layout pattern.</p>
    
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Behavior:</strong> On mobile (below the breakpoint), sidebars are completely hidden. 
        At the breakpoint, a 3-column grid appears with left sidebar, main content, and right sidebar.
    </div>
    
    <h3>Features</h3>
    <ul>
        <li>Responsive grid with configurable column widths</li>
        <li>Sidebars hidden on mobile for maximum content space</li>
        <li>Ideal for content-rich websites and blogs</li>
        <li>SEO-friendly with main content in the center</li>
    </ul>
    
    <h3>Configuration</h3>
    <pre class="bg-light p-3 rounded"><code>$page->setLayout(LayoutPattern::HOLY_GRAIL, Breakpoint::LG);
$page->setColumnWidths(3, 6, 3); // left, main, right</code></pre>
</div>
HTML);

echo $page->render();
