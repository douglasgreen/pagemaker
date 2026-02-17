<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$page = createPage('TabSet Widget - PageMaker Demo', $renderer);
$page->usePreset('no-sidebars');

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$horizontalTabs = new TabSet(
    tabs: [
        'Overview' => '<p>This is the overview content. Tabs allow users to switch between different views.</p>',
        'Features' => '<ul><li>Feature 1: Easy to use</li><li>Feature 2: Fully responsive</li></ul>',
        'Reviews' => '<blockquote class="blockquote"><p>"Great product!" - Happy User</p></blockquote>',
    ],
    style: 'tabs',
    orientation: 'horizontal',
);

$verticalPills = new TabSet(
    tabs: [
        'Profile' => '<h4>User Profile</h4><p>Manage your profile settings here.</p>',
        'Security' => '<h4>Security Settings</h4><p>Two-factor authentication, password changes.</p>',
        'Notifications' => '<h4>Notification Preferences</h4><p>Email, push, and SMS settings.</p>',
    ],
    style: 'pills',
    orientation: 'vertical',
);

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Widgets' => '/widgets/',
    'TabSet' => null,
]));

$content = '<div class="p-4"><h1>TabSet Widget</h1><p class="lead">Organize content in tabbed panels with horizontal or vertical layouts.</p><h3>Horizontal Tabs</h3></div>';
$content .= '<div class="px-4">' . $horizontalTabs->render() . '</div>';
$content .= '<div class="p-4"><h3>Vertical Pills</h3></div>';
$content .= '<div class="px-4">' . $verticalPills->render() . '</div>';
$content .= <<<'HTML'
<div class="p-4">
    <h3>Configuration Options</h3>
    <table class="table table-bordered">
        <thead><tr><th>Option</th><th>Type</th><th>Default</th><th>Description</th></tr></thead>
        <tbody>
            <tr><td><code>tabs</code></td><td>array</td><td>required</td><td>Tab panels (label => content)</td></tr>
            <tr><td><code>style</code></td><td>string</td><td>'tabs'</td><td>'tabs' or 'pills'</td></tr>
            <tr><td><code>orientation</code></td><td>string</td><td>'horizontal'</td><td>'horizontal' or 'vertical'</td></tr>
            <tr><td><code>id</code></td><td>string|null</td><td>auto-generated</td><td>Unique ID prefix</td></tr>
        </tbody>
    </table>
    
    <h3>Usage Example</h3>
    <pre class="bg-light p-3 rounded"><code>$tabSet = new TabSet(
    tabs: [
        'Tab 1' => '&lt;p&gt;Content 1&lt;/p&gt;',
        'Tab 2' => '&lt;p&gt;Content 2&lt;/p&gt;',
    ],
    style: 'pills',
    orientation: 'vertical',
);
$page->setMainContent($tabSet);</code></pre>
</div>
HTML;

$page->setMainContent($content);

echo $page->render();
