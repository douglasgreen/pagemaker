<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Components\Breadcrumb;
use DouglasGreen\PageMaker\Components\Footer;

$page = createPage('Footer Component - PageMaker Demo', $renderer);
$page->usePreset('no-sidebars');

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$simpleFooter = new Footer(copyright: '© 2026 Simple Company');

$fullFooter = new Footer(
    columns: [
        'Product' => ['Features' => '#features', 'Pricing' => '#pricing'],
        'Company' => ['About' => '#about', 'Careers' => '#careers'],
        'Legal' => ['Privacy' => '#privacy', 'Terms' => '#terms'],
    ],
    copyright: '© 2026 Full Company Inc.',
    socialLinks: ['twitter' => 'https://twitter.com', 'github' => 'https://github.com'],
);

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Components' => '/components/',
    'Footer' => null,
]));

$content = '<div class="p-4"><h1>Footer Component</h1><p class="lead">Multi-column footer with social links and copyright.</p><h3>Full Footer Example</h3></div>';
$content .= $fullFooter->render();
$content .= '<div class="p-4"><h3>Simple Footer (copyright only)</h3></div>';
$content .= $simpleFooter->render();
$content .= <<<'HTML'
<div class="p-4">
    <h3>Configuration Options</h3>
    <table class="table table-bordered">
        <thead><tr><th>Option</th><th>Type</th><th>Default</th><th>Description</th></tr></thead>
        <tbody>
            <tr><td><code>columns</code></td><td>array</td><td>[]</td><td>Multi-column links (heading => [label => href])</td></tr>
            <tr><td><code>copyright</code></td><td>string</td><td>''</td><td>Copyright text</td></tr>
            <tr><td><code>socialLinks</code></td><td>array</td><td>[]</td><td>Social platform links (platform => url)</td></tr>
        </tbody>
    </table>
    
    <h3>Usage Example</h3>
    <pre class="bg-light p-3 rounded"><code>$footer = new Footer(
    columns: [
        'Product' => ['Features' => '#', 'Pricing' => '#'],
        'Company' => ['About' => '#', 'Blog' => '#'],
    ],
    copyright: '© 2026 My Company',
    socialLinks: ['twitter' => '#', 'github' => '#'],
);
$page->setFooter($footer);</code></pre>
</div>
HTML;

$page->setMainContent($content);

echo $page->render();
