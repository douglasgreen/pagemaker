<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Components\Breadcrumb;
use DouglasGreen\PageMaker\Components\Navbar;

$page = createPage('Navbar Component - PageMaker Demo', $renderer);
$page->usePreset('no-sidebars');

$navbarDark = new Navbar(
    brandName: 'Dark Theme',
    brandUrl: '#',
    brandLogo: 'https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg',
    items: ['Home' => '#', 'Features' => '#', 'Pricing' => '#', 'About' => '#'],
    theme: 'dark',
    fixed: false,
    breakpoint: 'lg',
);

$navbarLight = new Navbar(
    brandName: 'Light Theme',
    brandUrl: '#',
    items: ['Products' => '#', 'Services' => '#', 'Contact' => '#'],
    theme: 'light',
    fixed: false,
    breakpoint: 'md',
);

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Components' => '/components/',
    'Navbar' => null,
]));

$content = '<div class="p-4"><h1>Navbar Component</h1><p class="lead">Responsive navigation bar with mobile collapse.</p><h3 class="mt-4">Dark Theme</h3></div>';
$content .= $navbarDark->render();
$content .= '<div class="p-4"><h3>Light Theme</h3></div>';
$content .= '<div class="bg-light p-2">' . $navbarLight->render() . '</div>';
$content .= <<<'HTML'
<div class="p-4">
    <h3>Configuration Options</h3>
    <table class="table table-bordered">
        <thead><tr><th>Option</th><th>Type</th><th>Default</th><th>Description</th></tr></thead>
        <tbody>
            <tr><td><code>brandName</code></td><td>string</td><td>required</td><td>Site/brand name</td></tr>
            <tr><td><code>brandUrl</code></td><td>string</td><td>'/'</td><td>Brand link URL</td></tr>
            <tr><td><code>brandLogo</code></td><td>string|null</td><td>null</td><td>Optional logo image URL</td></tr>
            <tr><td><code>items</code></td><td>array</td><td>[]</td><td>Navigation items (label => href)</td></tr>
            <tr><td><code>theme</code></td><td>string</td><td>'dark'</td><td>'dark' or 'light'</td></tr>
            <tr><td><code>fixed</code></td><td>bool</td><td>true</td><td>Sticky top position</td></tr>
            <tr><td><code>breakpoint</code></td><td>string</td><td>'lg'</td><td>Collapse breakpoint</td></tr>
        </tbody>
    </table>
    
    <h3>Usage Example</h3>
    <pre class="bg-light p-3 rounded"><code>$navbar = new Navbar(
    brandName: 'My App',
    brandUrl: '/',
    brandLogo: '/images/logo.svg',
    items: ['Home' => '/', 'About' => '/about'],
    theme: 'dark',
    fixed: true,
);
$page->setHeader($navbar);</code></pre>
</div>
HTML;

$page->setMainContent($content);

echo $page->render();
