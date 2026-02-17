<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Enums\Breakpoint;
use DouglasGreen\PageMaker\Enums\LayoutPattern;

$page = createPage('Stacked Layout - PageMaker Demo', $renderer);

$page->setLayout(LayoutPattern::STACKED, Breakpoint::LG);
$page->setColumnWidths(3, 6, 3);

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Layouts' => '/layouts/',
    'Stacked' => null,
]));

$page->setLeftSidebar(createSidebar());

$page->setRightSidebar(new Sidebar(
    navItems: [
        ['icon' => 'clock-history', 'label' => 'Recent', 'href' => '#'],
        ['icon' => 'star', 'label' => 'Favorites', 'href' => '#'],
        ['icon' => 'download', 'label' => 'Downloads', 'href' => '#'],
    ],
    heading: 'Activity',
));

$page->setMainContent(<<<'HTML'
<div class="p-4">
    <h1>Stacked Layout</h1>
    <p class="lead">Mobile-first with main content first in the DOM.</p>
    
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Behavior:</strong> Main content is first in the DOM for SEO. On mobile, sidebars stack 
        below the main content. At the breakpoint, visual order is rearranged to left-main-right.
    </div>
    
    <h3>Features</h3>
    <ul>
        <li>SEO-optimized: main content first in source order</li>
        <li>Mobile-friendly stacked layout</li>
        <li>Visual reordering at breakpoint</li>
        <li>Great for content-focused sites</li>
    </ul>
    
    <h3>Configuration</h3>
    <pre class="bg-light p-3 rounded"><code>$page->setLayout(LayoutPattern::STACKED, Breakpoint::LG);
$page->setColumnWidths(3, 6, 3);</code></pre>
    
    <h3>DOM Order vs Visual Order</h3>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">DOM Order</h5>
                    <ol>
                        <li>Main Content</li>
                        <li>Left Sidebar</li>
                        <li>Right Sidebar</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">Visual Order (Desktop)</h5>
                    <ol>
                        <li>Left Sidebar</li>
                        <li>Main Content</li>
                        <li>Right Sidebar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
HTML);

echo $page->render();
