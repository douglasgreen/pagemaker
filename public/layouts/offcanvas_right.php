<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Enums\Breakpoint;
use DouglasGreen\PageMaker\Enums\LayoutPattern;

$page = createPage('Offcanvas Right Layout - PageMaker Demo', $renderer);

$page->setLayout(LayoutPattern::OFFCANVAS_RIGHT, Breakpoint::LG);
$page->setColumnWidths(8, 4, 0);

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Layouts' => '/layouts/',
    'Offcanvas Right' => null,
]));

$page->setRightSidebar(new Sidebar(
    navItems: [
        ['icon' => 'funnel', 'label' => 'Filters', 'href' => '#', 'active' => true],
        ['icon' => 'calendar', 'label' => 'Date Range', 'href' => '#'],
        ['icon' => 'tag', 'label' => 'Categories', 'href' => '#'],
        ['icon' => 'geo-alt', 'label' => 'Location', 'href' => '#'],
    ],
    heading: 'Filters',
));

$page->setMainContent(<<<'HTML'
<div class="p-4">
    <h1>Offcanvas Right Layout</h1>
    <p class="lead">Right sidebar slides in from the right on mobile.</p>
    
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Behavior:</strong> On mobile, click the "Sidebar" button to slide in the sidebar from the right.
        Great for filters, settings panels, or detail views.
    </div>
    
    <h3>Features</h3>
    <ul>
        <li>Right-side drawer for mobile</li>
        <li>Perfect for filter panels</li>
        <li>Ideal for detail/properties panels</li>
        <li>Non-intrusive on desktop</li>
    </ul>
    
    <h3>Configuration</h3>
    <pre class="bg-light p-3 rounded"><code>$page->setLayout(LayoutPattern::OFFCANVAS_RIGHT, Breakpoint::LG);
$page->setColumnWidths(8, 4, 0);</code></pre>
    
    <h3>Use Cases</h3>
    <div class="row g-3 mt-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-search me-2"></i>Search Results</h5>
                    <p class="card-text small">Filters panel on the right</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-file-text me-2"></i>Document Editor</h5>
                    <p class="card-text small">Properties/outline panel</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-cart me-2"></i>E-commerce</h5>
                    <p class="card-text small">Shopping cart sidebar</p>
                </div>
            </div>
        </div>
    </div>
</div>
HTML);

echo $page->render();
