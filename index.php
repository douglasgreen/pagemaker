<?php
use App\Layout\BootstrapPage;
use App\Layout\Breakpoint;
use App\Layout\Components\Footer;
use App\Layout\Components\Header;
use App\Layout\Components\Menu;
use App\Layout\Components\SearchForm;
use App\Layout\LayoutType;

require_once __DIR__ . '/vendor/autoload.php';

// 1. Create page with HOLY_GRAIL layout, sidebars hide below LG (992px)
$page = new BootstrapPage('Dashboard', 'en', 'UTF-8');
$page->setLayout(LayoutType::HOLY_GRAIL, Breakpoint::LG)
     ->setColumnWidths(2, 8, 2)  // Left: 2, Main: 8, Right: 2
     ->addExternalCSS('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css')
     ->addExternalJS('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', 'head');

// 2. Build Header with dropdown menu and search
$headerMenu = new Menu();
$headerMenu->addLink('Home', '/', true)
    ->addDropdown('Products', [
        ['Analytics', '/analytics'],
        ['Reports', '/reports'],
        ['Export', '/export'],
    ])
    ->addLink('Settings', '/settings');

$header = new Header();
$header->setBrand('MyApp', '/')
       ->setMenu($headerMenu)
       ->setSearchForm(new SearchForm('/search', 'Search docs...'))
       ->setExpandBreakpoint(Breakpoint::LG); // Hamburger below 992px

$page->setHeader($header);

// 3. Build Left Nav (vertical list)
$leftNav = new Menu();
$leftNav->addLink('Dashboard', '/dash', true)
        ->addLink('Users', '/users')
        ->addLink('Billing', '/billing');
$page->setLeftNav($leftNav);

// 4. Main content (can be string, callable, or Renderable)
$page->setMain(function (): string|false {
    ob_start();
    ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>
    <p>Main content area...</p>
    <?php
    return ob_get_clean();
});

// 5. Right Nav (simple HTML string)
$page->setRightNav('<div class="p-3 bg-light rounded"><h6>Quick Links</h6><p>Sidebar content</p></div>');

// 6. Build Footer with rows/columns
$footer = new Footer();
$row = $footer->addRow();
$row->addColumn(4, '&copy; 2024 Company', Breakpoint::MD)
    ->addColumn(4, '<a href="/privacy">Privacy</a>', Breakpoint::MD)
    ->addColumn(4, '<a href="/terms">Terms</a>', Breakpoint::MD);
$page->setFooter($footer);

// 7. Add an error alert (appears above header)
$page->addAlert('System maintenance scheduled for tonight.', 'warning', true);

// 8. Render
echo $page->render();
