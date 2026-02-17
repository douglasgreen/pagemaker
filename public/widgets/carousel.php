<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

$page = createPage('Carousel Widget - PageMaker Demo', $renderer);
$page->usePreset('no-sidebars');

$page->setHeader(createNavbar());
$page->setFooter(createFooter());

$basicCarousel = new Carousel(
    slides: [
        ['src' => 'https://picsum.photos/seed/slide1/1200/400', 'alt' => 'Slide 1', 'caption' => 'First Slide', 'description' => 'This is the first slide caption'],
        ['src' => 'https://picsum.photos/seed/slide2/1200/400', 'alt' => 'Slide 2', 'caption' => 'Second Slide', 'description' => 'This is the second slide caption'],
        ['src' => 'https://picsum.photos/seed/slide3/1200/400', 'alt' => 'Slide 3', 'caption' => 'Third Slide', 'description' => 'This is the third slide caption'],
    ],
    controls: true,
    indicators: true,
);

$fadeCarousel = new Carousel(
    slides: [
        ['src' => 'https://picsum.photos/seed/fade1/1200/400', 'alt' => 'Fade 1'],
        ['src' => 'https://picsum.photos/seed/fade2/1200/400', 'alt' => 'Fade 2'],
        ['src' => 'https://picsum.photos/seed/fade3/1200/400', 'alt' => 'Fade 3'],
    ],
    controls: true,
    indicators: true,
    fade: true,
    interval: 3000,
);

$page->setBreadcrumb(new Breadcrumb([
    'Home' => '/',
    'Widgets' => '/widgets/',
    'Carousel' => null,
]));

$content = '<div class="p-4"><h1>Carousel Widget</h1><p class="lead">Image/content carousel with controls and indicators.</p><h3>Standard Carousel</h3></div>';
$content .= '<div class="px-4">' . $basicCarousel->render() . '</div>';
$content .= '<div class="p-4"><h3>Fade Transition Carousel</h3></div>';
$content .= '<div class="px-4">' . $fadeCarousel->render() . '</div>';
$content .= <<<'HTML'
<div class="p-4">
    <h3>Configuration Options</h3>
    <table class="table table-bordered">
        <thead><tr><th>Option</th><th>Type</th><th>Default</th><th>Description</th></tr></thead>
        <tbody>
            <tr><td><code>slides</code></td><td>array</td><td>required</td><td>Slides (src, alt, caption?, description?)</td></tr>
            <tr><td><code>controls</code></td><td>bool</td><td>true</td><td>Show prev/next arrows</td></tr>
            <tr><td><code>indicators</code></td><td>bool</td><td>true</td><td>Show dot indicators</td></tr>
            <tr><td><code>fade</code></td><td>bool</td><td>false</td><td>Use crossfade transition</td></tr>
            <tr><td><code>interval</code></td><td>int</td><td>5000</td><td>Auto-play interval (ms, 0=off)</td></tr>
            <tr><td><code>id</code></td><td>string|null</td><td>auto-generated</td><td>Unique ID</td></tr>
        </tbody>
    </table>
    
    <h3>Usage Example</h3>
    <pre class="bg-light p-3 rounded"><code>$carousel = new Carousel(
    slides: [
        ['src' => '/images/slide1.jpg', 'alt' => 'Slide 1', 'caption' => 'Welcome'],
        ['src' => '/images/slide2.jpg', 'alt' => 'Slide 2'],
    ],
    controls: true,
    indicators: true,
    fade: false,
    interval: 5000,
);
$page->setMainContent($carousel);</code></pre>
</div>
HTML;

$page->setMainContent($content);

echo $page->render();
