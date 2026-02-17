<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use DouglasGreen\PageMaker\Enums\LayoutPattern;

$page = createPage('PageMaker Demo - Home', $renderer);

$page->setHeader(createNavbar());

$layouts = [
    ['name' => 'Holy Grail', 'pattern' => LayoutPattern::HOLY_GRAIL, 'desc' => 'Classic 3-column layout with hidden sidebars on mobile'],
    ['name' => 'Offcanvas Left', 'pattern' => LayoutPattern::OFFCANVAS_LEFT, 'desc' => 'Left sidebar slides in as drawer on mobile'],
    ['name' => 'Offcanvas Right', 'pattern' => LayoutPattern::OFFCANVAS_RIGHT, 'desc' => 'Right sidebar slides in as drawer on mobile'],
    ['name' => 'Stacked', 'pattern' => LayoutPattern::STACKED, 'desc' => 'Main first in DOM, sidebars stack below on mobile'],
    ['name' => 'Fixed Sidebar', 'pattern' => LayoutPattern::FIXED_SIDEBAR, 'desc' => 'Fixed-position sidebar with independent scrolling'],
    ['name' => 'Partially Collapsing', 'pattern' => LayoutPattern::PARTIALLY_COLLAPSING, 'desc' => 'Sidebar narrows to icons on mobile'],
    ['name' => 'Accordion Sidebar', 'pattern' => LayoutPattern::ACCORDION_SIDEBAR, 'desc' => 'Sidebar with collapsible accordion sections'],
    ['name' => 'Overlay Drawer', 'pattern' => LayoutPattern::OVERLAY_DRAWER, 'desc' => 'Full-screen overlay drawer on mobile'],
    ['name' => 'Mini Icon Sidebar', 'pattern' => LayoutPattern::MINI_ICON_SIDEBAR, 'desc' => 'Narrow icon strip, expands on hover'],
];

$components = [
    ['name' => 'Navbar', 'url' => '/components/navbar.php', 'desc' => 'Responsive navigation bar with collapse'],
    ['name' => 'Hero Section', 'url' => '/components/hero.php', 'desc' => 'Full-width hero banner with CTA'],
    ['name' => 'Sidebar', 'url' => '/components/sidebar.php', 'desc' => 'Navigation sidebar with nested items'],
    ['name' => 'Footer', 'url' => '/components/footer.php', 'desc' => 'Multi-column footer with social links'],
    ['name' => 'Breadcrumb', 'url' => '/components/breadcrumb.php', 'desc' => 'Breadcrumb navigation trail'],
];

$widgets = [
    ['name' => 'TabSet', 'url' => '/widgets/tabset.php', 'desc' => 'Tabbed content panels'],
    ['name' => 'Accordion', 'url' => '/widgets/accordion.php', 'desc' => 'Collapsible content sections'],
    ['name' => 'Modal', 'url' => '/widgets/modal.php', 'desc' => 'Modal dialogs'],
    ['name' => 'Carousel', 'url' => '/widgets/carousel.php', 'desc' => 'Image/content carousel'],
    ['name' => 'Form', 'url' => '/widgets/form.php', 'desc' => 'Form builder with various field types'],
];

ob_start();
?>
<div class="px-4 py-5 my-5 text-center">
    <h1 class="display-5 fw-bold text-body-emphasis">PageMaker Demo</h1>
    <p class="lead mb-4">A mobile-first, responsive page layout system built on Bootstrap 5.3, PHP 8.2+, and Twig.</p>
</div>

<div class="container">
    <div class="row g-4">
        <div class="col-12">
            <h2 class="border-bottom pb-2 mb-4">Layout Patterns</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($layouts as $layout): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-layout-text-window me-2"></i>
                                <?= htmlspecialchars($layout['name']); ?>
                            </h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($layout['desc']); ?></p>
                            <a href="/layouts/<?= $layout['pattern']->value; ?>.php" class="btn btn-primary">View Demo</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-12 mt-5">
            <h2 class="border-bottom pb-2 mb-4">Structural Components</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($components as $component): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-puzzle me-2"></i>
                                <?= htmlspecialchars($component['name']); ?>
                            </h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($component['desc']); ?></p>
                            <a href="<?= $component['url']; ?>" class="btn btn-outline-primary">View Demo</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-12 mt-5">
            <h2 class="border-bottom pb-2 mb-4">Interactive Widgets</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($widgets as $widget): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="bi bi-box me-2"></i>
                                <?= htmlspecialchars($widget['name']); ?>
                            </h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($widget['desc']); ?></p>
                            <a href="<?= $widget['url']; ?>" class="btn btn-outline-secondary">View Demo</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php

$content = ob_get_clean();
$page->setMainContent($content);
$page->setFooter(createFooter());

echo $page->render();
