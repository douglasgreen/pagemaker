<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Components\Breadcrumb;
use DouglasGreen\PageMaker\Components\Modal;

$page = createPage('Modal Widget - PageMaker Demo', $renderer);
$page->usePreset('no-sidebars');

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$basicModal = new Modal(
    title: 'Basic Modal',
    body: '<p>This is a basic modal dialog. You can put any content here.</p>',
);

$formModal = new Modal(
    title: 'Confirm Action',
    body: '<p>Are you sure you want to delete this item? This action cannot be undone.</p>',
    footerHtml: '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger">Delete</button>',
    size: 'sm',
);

$largeModal = new Modal(
    title: 'Large Modal',
    body: '<p>This is a large modal with scrollable content.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
    size: 'lg',
    scrollable: true,
);

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Widgets' => '/widgets/',
    'Modal' => null,
]));

$content = '<div class="p-4"><h1>Modal Widget</h1><p class="lead">Modal dialogs for user interactions.</p></div>';
$content .= '<div class="px-4"><div class="row g-3">';
$content .= '<div class="col-md-4"><div class="card"><div class="card-body"><h5>Basic Modal</h5>' . $basicModal->triggerButton('Open Basic Modal') . '</div></div></div>';
$content .= '<div class="col-md-4"><div class="card"><div class="card-body"><h5>Form Modal</h5>' . $formModal->triggerButton('Open Form Modal', 'btn btn-warning') . '</div></div></div>';
$content .= '<div class="col-md-4"><div class="card"><div class="card-body"><h5>Large Modal</h5>' . $largeModal->triggerButton('Open Large Modal', 'btn btn-info') . '</div></div></div>';
$content .= '</div></div>';

// Add the modal markup
$content .= $basicModal->render();
$content .= $formModal->render();
$content .= $largeModal->render();

$content .= <<<'HTML'
<div class="p-4">
    <h3>Configuration Options</h3>
    <table class="table table-bordered">
        <thead><tr><th>Option</th><th>Type</th><th>Default</th><th>Description</th></tr></thead>
        <tbody>
            <tr><td><code>title</code></td><td>string</td><td>required</td><td>Modal title</td></tr>
            <tr><td><code>body</code></td><td>string|Renderable</td><td>required</td><td>Modal body content</td></tr>
            <tr><td><code>footerHtml</code></td><td>string|null</td><td>null</td><td>Footer HTML (buttons)</td></tr>
            <tr><td><code>size</code></td><td>string</td><td>''</td><td>'sm', 'lg', 'xl', 'fullscreen'</td></tr>
            <tr><td><code>centered</code></td><td>bool</td><td>true</td><td>Vertically center</td></tr>
            <tr><td><code>scrollable</code></td><td>bool</td><td>false</td><td>Scrollable body</td></tr>
            <tr><td><code>staticBackdrop</code></td><td>bool</td><td>false</td><td>Don't close on backdrop click</td></tr>
        </tbody>
    </table>
    
    <h3>Usage Example</h3>
    <pre class="bg-light p-3 rounded"><code>$modal = new Modal(
    title: 'Confirm',
    body: '&lt;p&gt;Are you sure?&lt;/p&gt;',
    footerHtml: '&lt;button class="btn btn-primary"&gt;OK&lt;/button&gt;',
);

echo $modal->triggerButton('Open Modal');
echo $modal->render();</code></pre>
</div>
HTML;

$page->setMainContent($content);

echo $page->render();
