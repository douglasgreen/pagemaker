<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Components\Accordion;
use DouglasGreen\PageMaker\Components\Breadcrumb;

$page = createPage('Accordion Widget - PageMaker Demo', $renderer);
$page->usePreset('no-sidebars');

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$standardAccordion = new Accordion(
    sections: [
        'What is PageMaker?' => '<p>PageMaker is a PHP library for building responsive Bootstrap layouts with Twig templates.</p>',
        'How do I install it?' => '<p>Install via Composer: <code>composer require douglasgreen/pagemaker</code></p>',
        'Is it responsive?' => '<p>Yes! All layouts are mobile-first and fully responsive using Bootstrap 5.3.</p>',
    ],
);

$alwaysOpenAccordion = new Accordion(
    sections: [
        'Section A' => '<p>Content for section A. Multiple sections can be open at once.</p>',
        'Section B' => '<p>Content for section B. This accordion allows multiple open sections.</p>',
        'Section C' => '<p>Content for section C. Each section is independent.</p>',
    ],
    alwaysOpen: true,
);

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Widgets' => '/widgets/',
    'Accordion' => null,
]));

$content = '<div class="p-4"><h1>Accordion Widget</h1><p class="lead">Collapsible content sections with optional always-open mode.</p><h3>Standard Accordion</h3></div>';
$content .= '<div class="px-4">' . $standardAccordion->render() . '</div>';
$content .= '<div class="p-4"><h3>Always Open (multiple sections can be expanded)</h3></div>';
$content .= '<div class="px-4">' . $alwaysOpenAccordion->render() . '</div>';
$content .= <<<'HTML'
<div class="p-4">
    <h3>Configuration Options</h3>
    <table class="table table-bordered">
        <thead><tr><th>Option</th><th>Type</th><th>Default</th><th>Description</th></tr></thead>
        <tbody>
            <tr><td><code>sections</code></td><td>array</td><td>required</td><td>Accordion sections (heading => body)</td></tr>
            <tr><td><code>alwaysOpen</code></td><td>bool</td><td>false</td><td>Allow multiple open sections</td></tr>
            <tr><td><code>flush</code></td><td>bool</td><td>false</td><td>Remove borders for edge-to-edge</td></tr>
            <tr><td><code>id</code></td><td>string|null</td><td>auto-generated</td><td>Unique ID</td></tr>
        </tbody>
    </table>
    
    <h3>Usage Example</h3>
    <pre class="bg-light p-3 rounded"><code>$accordion = new Accordion(
    sections: [
        'FAQ 1' => '&lt;p&gt;Answer 1&lt;/p&gt;',
        'FAQ 2' => '&lt;p&gt;Answer 2&lt;/p&gt;',
    ],
    alwaysOpen: true,
);
$page->setMainContent($accordion);</code></pre>
</div>
HTML;

$page->setMainContent($content);

echo $page->render();
