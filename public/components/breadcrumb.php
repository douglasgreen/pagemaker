<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$page = createPage('Breadcrumb Component - PageMaker Demo', $renderer);
$page->usePreset('no-sidebars');

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$simpleBreadcrumb = new Breadcrumb([
    'Home' => '/',
    'Products' => '/products',
    'Current Item' => null,
]);

$deepBreadcrumb = new Breadcrumb([
    'Home' => '/',
    'Admin' => '/admin',
    'Users' => '/admin/users',
    'Edit' => '/admin/users/edit',
    'John Doe' => null,
]);

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Components' => '/components/',
    'Breadcrumb' => null,
]));

$content = '<div class="p-4"><h1>Breadcrumb Component</h1><p class="lead">Navigation breadcrumb trail for hierarchical content.</p><h3>Simple Breadcrumb</h3></div>';
$content .= '<div class="px-4">' . $simpleBreadcrumb->render() . '</div>';
$content .= '<div class="p-4"><h3>Deep Nesting</h3></div>';
$content .= '<div class="px-4">' . $deepBreadcrumb->render() . '</div>';
$content .= <<<'HTML'
<div class="p-4 mt-4">
    <h3>How It Works</h3>
    <p>Pass an associative array where:</p>
    <ul>
        <li><strong>Key</strong> = Link text</li>
        <li><strong>Value</strong> = URL (or <code>null</code> for the current/active page)</li>
    </ul>
    
    <h3>Configuration</h3>
    <pre class="bg-light p-3 rounded"><code>$breadcrumb = new Breadcrumb([
    'Home' => '/',
    'Category' => '/category',
    'Item' => null,  // Current page - no link
]);
$page->setBreadcrumb($breadcrumb);</code></pre>
    
    <h3>Accessibility</h3>
    <p>The breadcrumb component includes proper ARIA attributes:</p>
    <ul>
        <li><code>nav aria-label="breadcrumb"</code> wrapper</li>
        <li><code>aria-current="page"</code> on the active item</li>
        <li>Semantic <code>&lt;ol&gt;</code> list structure</li>
    </ul>
</div>
HTML;

$page->setMainContent($content);

echo $page->render();
