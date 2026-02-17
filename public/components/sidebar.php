<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$page = createPage('Sidebar Component - PageMaker Demo', $renderer);
$page->usePreset('no-sidebars');

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$simpleSidebar = new Sidebar(
    navItems: [
        ['icon' => 'house', 'label' => 'Home', 'href' => '#'],
        ['icon' => 'info-circle', 'label' => 'About', 'href' => '#'],
        ['icon' => 'envelope', 'label' => 'Contact', 'href' => '#'],
    ],
);

$nestedSidebar = new Sidebar(
    navItems: [
        ['icon' => 'speedometer2', 'label' => 'Dashboard', 'href' => '#', 'active' => true],
        ['icon' => 'folder', 'label' => 'Projects', 'href' => '#', 'children' => [
            ['icon' => 'folder2-open', 'label' => 'Active', 'href' => '#active'],
            ['icon' => 'clock-history', 'label' => 'Archived', 'href' => '#archived'],
        ]],
        ['icon' => 'people', 'label' => 'Team', 'href' => '#'],
        ['icon' => 'gear', 'label' => 'Settings', 'href' => '#'],
    ],
    heading: 'Main Menu',
);

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Components' => '/components/',
    'Sidebar' => null,
]));

$content = '<div class="p-4"><h1>Sidebar Component</h1><p class="lead">Navigation sidebar with support for nested items.</p><h3>Simple Sidebar</h3></div>';
$content .= '<div class="row g-4 p-4"><div class="col-md-6"><div class="border rounded p-3 bg-light" style="min-height: 200px;">';
$content .= $simpleSidebar->render();
$content .= '</div></div>';
$content .= '<div class="col-md-6"><h4>Nested Sidebar with Heading</h4><div class="border rounded p-3 bg-light" style="min-height: 200px;">';
$content .= $nestedSidebar->render();
$content .= '</div></div></div>';
$content .= <<<'HTML'
<div class="p-4">
    <h3>Nav Item Structure</h3>
    <table class="table table-bordered">
        <thead><tr><th>Key</th><th>Type</th><th>Required</th><th>Description</th></tr></thead>
        <tbody>
            <tr><td><code>icon</code></td><td>string</td><td>Yes</td><td>Bootstrap Icons class (without "bi-" prefix)</td></tr>
            <tr><td><code>label</code></td><td>string</td><td>Yes</td><td>Display text</td></tr>
            <tr><td><code>href</code></td><td>string</td><td>Yes</td><td>Link URL</td></tr>
            <tr><td><code>active</code></td><td>bool</td><td>No</td><td>Mark as current page</td></tr>
            <tr><td><code>children</code></td><td>array</td><td>No</td><td>Nested nav items</td></tr>
        </tbody>
    </table>
    
    <h3>Usage Example</h3>
    <pre class="bg-light p-3 rounded"><code>$sidebar = new Sidebar(
    navItems: [
        ['icon' => 'house', 'label' => 'Home', 'href' => '/', 'active' => true],
        ['icon' => 'folder', 'label' => 'Projects', 'href' => '/projects', 'children' => [
            ['icon' => 'folder2', 'label' => 'Active', 'href' => '/projects/active'],
        ]],
    ],
    heading: 'Navigation',
);
$page->setLeftSidebar($sidebar);</code></pre>
</div>
HTML;

$page->setMainContent($content);

echo $page->render();
