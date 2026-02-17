<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Components\Accordion;
use DouglasGreen\PageMaker\Components\Breadcrumb;
use DouglasGreen\PageMaker\Enums\Breakpoint;
use DouglasGreen\PageMaker\Enums\LayoutPattern;

$page = createPage('Accordion Sidebar Layout - PageMaker Demo', $renderer);

$page->setLayout(LayoutPattern::ACCORDION_SIDEBAR, Breakpoint::LG);
$page->setColumnWidths(3, 9, 0);

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Layouts' => '/layouts/',
    'Accordion Sidebar' => null,
]));

$accordion = new Accordion(
    sections: [
        'Dashboard' => '<a class="nav-link" href="#">Overview</a><a class="nav-link" href="#">Analytics</a><a class="nav-link" href="#">Reports</a>',
        'Content' => '<a class="nav-link" href="#">Pages</a><a class="nav-link" href="#">Posts</a><a class="nav-link" href="#">Media</a>',
        'Settings' => '<a class="nav-link" href="#">General</a><a class="nav-link" href="#">Users</a><a class="nav-link" href="#">Permissions</a>',
    ],
    alwaysOpen: false,
    flush: true,
);

$page->setLeftSidebar($accordion);

$page->setMainContent(<<<'HTML'
<div class="p-4">
    <h1>Accordion Sidebar Layout</h1>
    <p class="lead">Sidebar with collapsible accordion navigation.</p>
    
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Behavior:</strong> The sidebar contains an accordion component for deep navigation hierarchies.
        Click on section headers to expand/collapse navigation groups.
    </div>
    
    <h3>Features</h3>
    <ul>
        <li>Collapsible navigation sections</li>
        <li>Great for deep navigation hierarchies</li>
        <li>Mobile-friendly collapsed state</li>
        <li>Reduces visual clutter</li>
    </ul>
    
    <h3>Configuration</h3>
    <pre class="bg-light p-3 rounded"><code>$accordion = new Accordion(
    sections: [
        'Dashboard' => '&lt;nav links...&gt;',
        'Content' => '&lt;nav links...&gt;',
        'Settings' => '&lt;nav links...&gt;',
    ],
    alwaysOpen: false,
    flush: true,
);
$page->setLeftSidebar($accordion);</code></pre>
    
    <h3>Ideal Use Cases</h3>
    <ul>
        <li>Documentation sites with many categories</li>
        <li>CMS admin panels</li>
        <li>Knowledge bases</li>
        <li>Product catalogs with categories</li>
    </ul>
</div>
HTML);

echo $page->render();
