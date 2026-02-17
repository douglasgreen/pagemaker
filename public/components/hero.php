<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use DouglasGreen\PageMaker\Components\Breadcrumb;
use DouglasGreen\PageMaker\Components\HeroSection;

$page = createPage('Hero Section Component - PageMaker Demo', $renderer);
$page->usePreset('no-sidebars');

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$heroDark = new HeroSection(
    title: 'Welcome to PageMaker',
    subtitle: 'Build beautiful, responsive layouts with ease using Bootstrap 5.3 and PHP 8.2+',
    ctaLabel: 'Get Started',
    ctaUrl: '#',
    backgroundImage: 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1920',
    theme: 'dark',
);

$heroLight = new HeroSection(
    title: 'Simple & Clean',
    subtitle: 'A light-themed hero section without background image',
    ctaLabel: 'Learn More',
    ctaUrl: '#',
    theme: 'light',
);

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Components' => '/components/',
    'Hero Section' => null,
]));

$content = '<div class="p-4"><h1>Hero Section Component</h1><p class="lead">Full-width hero banners with optional background images and CTAs.</p></div>';
$content .= $heroDark->render();
$content .= '<div class="p-4"><h3>Light Theme (no background image)</h3></div>';
$content .= '<div class="bg-light p-4">' . $heroLight->render() . '</div>';
$content .= <<<'HTML'
<div class="p-4">
    <h3>Configuration Options</h3>
    <table class="table table-bordered">
        <thead><tr><th>Option</th><th>Type</th><th>Default</th><th>Description</th></tr></thead>
        <tbody>
            <tr><td><code>title</code></td><td>string</td><td>required</td><td>Main heading text</td></tr>
            <tr><td><code>subtitle</code></td><td>string</td><td>''</td><td>Subtitle/description text</td></tr>
            <tr><td><code>ctaLabel</code></td><td>string|null</td><td>null</td><td>CTA button text</td></tr>
            <tr><td><code>ctaUrl</code></td><td>string|null</td><td>null</td><td>CTA button URL</td></tr>
            <tr><td><code>backgroundImage</code></td><td>string|null</td><td>null</td><td>Background image URL</td></tr>
            <tr><td><code>theme</code></td><td>string</td><td>'dark'</td><td>'dark' or 'light'</td></tr>
        </tbody>
    </table>
    
    <h3>Usage Example</h3>
    <pre class="bg-light p-3 rounded"><code>$hero = new HeroSection(
    title: 'Welcome to My App',
    subtitle: 'The best solution for your needs',
    ctaLabel: 'Sign Up',
    ctaUrl: '/register',
    backgroundImage: '/images/hero-bg.jpg',
    theme: 'dark',
);
$page->setHeroSection($hero);</code></pre>
</div>
HTML;

$page->setMainContent($content);

echo $page->render();
