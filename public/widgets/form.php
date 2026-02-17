<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$page = createPage('Form Widget - PageMaker Demo', $renderer);
$page->usePreset('no-sidebars');

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$contactForm = new Form(
    action: '/submit',
    method: 'POST',
    fields: [
        ['type' => 'text', 'name' => 'name', 'label' => 'Full Name', 'placeholder' => 'Enter your name', 'required' => true],
        ['type' => 'email', 'name' => 'email', 'label' => 'Email Address', 'placeholder' => 'you@example.com', 'required' => true],
        ['type' => 'select', 'name' => 'subject', 'label' => 'Subject', 'options' => ['general' => 'General Inquiry', 'support' => 'Technical Support', 'sales' => 'Sales'], 'required' => true],
        ['type' => 'textarea', 'name' => 'message', 'label' => 'Message', 'placeholder' => 'Your message here...', 'required' => true],
        ['type' => 'checkbox', 'name' => 'subscribe', 'label' => 'Subscribe to newsletter'],
    ],
    submitLabel: 'Send Message',
    csrfToken: true,
);

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Widgets' => '/widgets/',
    'Form' => null,
]));

$content = '<div class="p-4"><h1>Form Widget</h1><p class="lead">Form builder with various field types.</p><h3>Contact Form Example</h3></div>';
$content .= '<div class="px-4 col-md-8">' . $contactForm->render() . '</div>';
$content .= <<<'HTML'
<div class="p-4">
    <h3>Configuration Options</h3>
    <table class="table table-bordered">
        <thead><tr><th>Option</th><th>Type</th><th>Default</th><th>Description</th></tr></thead>
        <tbody>
            <tr><td><code>action</code></td><td>string</td><td>required</td><td>Form action URL</td></tr>
            <tr><td><code>method</code></td><td>string</td><td>'POST'</td><td>HTTP method</td></tr>
            <tr><td><code>fields</code></td><td>array</td><td>[]</td><td>Field definitions</td></tr>
            <tr><td><code>submitLabel</code></td><td>string</td><td>'Submit'</td><td>Submit button text</td></tr>
            <tr><td><code>csrfToken</code></td><td>bool</td><td>true</td><td>Include CSRF token field</td></tr>
        </tbody>
    </table>
    
    <h3>Field Types</h3>
    <table class="table table-bordered">
        <thead><tr><th>Type</th><th>Description</th><th>Special Keys</th></tr></thead>
        <tbody>
            <tr><td><code>text</code></td><td>Text input</td><td>placeholder, required, value</td></tr>
            <tr><td><code>email</code></td><td>Email input</td><td>placeholder, required, value</td></tr>
            <tr><td><code>password</code></td><td>Password input</td><td>placeholder, required</td></tr>
            <tr><td><code>number</code></td><td>Number input</td><td>placeholder, required, value</td></tr>
            <tr><td><code>select</code></td><td>Dropdown</td><td>options (value => label), required</td></tr>
            <tr><td><code>textarea</code></td><td>Text area</td><td>placeholder, required, value</td></tr>
            <tr><td><code>checkbox</code></td><td>Checkbox</td><td>value (checked state)</td></tr>
        </tbody>
    </table>
    
    <h3>Usage Example</h3>
    <pre class="bg-light p-3 rounded"><code>$form = new Form(
    action: '/submit',
    method: 'POST',
    fields: [
        ['type' => 'text', 'name' => 'name', 'label' => 'Name', 'required' => true],
        ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true],
        ['type' => 'textarea', 'name' => 'message', 'label' => 'Message'],
    ],
    submitLabel: 'Send',
    csrfToken: true,
);
$page->setMainContent($form);</code></pre>
</div>
HTML;

$page->setMainContent($content);

echo $page->render();
