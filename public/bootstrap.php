<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DouglasGreen\PageMaker\Components\Footer;
use DouglasGreen\PageMaker\Components\Navbar;
use DouglasGreen\PageMaker\Components\Sidebar;
use DouglasGreen\PageMaker\PageMaker;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Set up Twig
$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader, [
    'cache' => false,
    'debug' => true,
]);

// Create renderer closure
$renderer = fn (string $template, array $context): string => $twig->render($template, $context);

/**
 * Create a basic PageMaker instance with common assets.
 */
function createPage(string $title, callable $renderer): PageMaker
{
    $page = new PageMaker($renderer);

    $page->assets()
        ->addBootstrap()
        ->addBootstrapIcons()
        ->addCss('/css/pagemaker.css');

    $page->setTitle($title);

    return $page;
}

/**
 * Create a sample navbar.
 */
function createNavbar(): Navbar
{
    return new Navbar(
        brandName: 'PageMaker Demo',
        brandUrl: '/',
        items: [
            'Layouts' => '/layouts/',
            'Components' => '/components/',
            'Widgets' => '/widgets/',
            'Docs' => '#',
        ],
        theme: 'dark',
        fixed: true,
    );
}

/**
 * Create a sample footer.
 */
function createFooter(): Footer
{
    return new Footer(
        columns: [
            'Product' => [
                'Features' => '#features',
                'Pricing' => '#pricing',
                'Docs' => '#docs',
            ],
            'Company' => [
                'About' => '#about',
                'Blog' => '#blog',
                'Careers' => '#careers',
            ],
            'Support' => [
                'Help' => '#help',
                'Contact' => '#contact',
                'Status' => '#status',
            ],
        ],
        copyright: '© 2026 PageMaker Demo. All rights reserved.',
        socialLinks: [
            'twitter' => 'https://twitter.com',
            'github' => 'https://github.com',
            'linkedin' => 'https://linkedin.com',
        ],
    );
}

/**
 * Create a sample sidebar.
 */
function createSidebar(): Sidebar
{
    return new Sidebar(
        navItems: [
            ['icon' => 'house-door', 'label' => 'Dashboard', 'href' => '#', 'active' => true],
            ['icon' => 'speedometer2', 'label' => 'Analytics', 'href' => '#'],
            ['icon' => 'people', 'label' => 'Users', 'href' => '#'],
            ['icon' => 'folder', 'label' => 'Projects', 'href' => '#', 'children' => [
                ['icon' => 'folder2', 'label' => 'Active', 'href' => '#active'],
                ['icon' => 'archive', 'label' => 'Archived', 'href' => '#archived'],
            ]],
            ['icon' => 'gear', 'label' => 'Settings', 'href' => '#'],
        ],
        heading: 'Navigation',
    );
}
