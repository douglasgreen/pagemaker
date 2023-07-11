<?php

require 'vendor/autoload.php';

use PageMaker\Page;
use PageMaker\Widgets\Menu;
use PageMaker\Widgets\FooterNav;

$page = new Page('Testing');
$page->setStyle('pmNormalize', 'public/styles/pmNormalize.css');
$page->setStyle('pmHeader', 'public/styles/layouts/basic/pmPage.css');

$page->addSection('pmLeftNav', 'leftNav', '<div style="width: 100px; height: 100px; border: 1px solid black">Hello, world</div>');
$page->addSection('pmMain', 'main', '<div style="width: 100px; height: 100px; border: 1px solid black">Hello, world</div>');
$page->addSection('pmRightNav', 'rightNav', '<div style="width: 100px; height: 100px; border: 1px solid black">Hello, world</div>');

$menu = new Menu('Menu bar');
$menu->addLink('Home', '/');
$menu->addLink('About', '/about');
$servicesMenu = $menu->addSubmenu('Services');
$servicesMenu->addLink('Consulting', '/services/consulting');
$otherMenu = $servicesMenu->addSubmenu('Other');
$servicesMenu->addLink('Support', '/services/support');
$otherMenu->addLink('Feedly', 'https://feedly.com/');
$newMenu = $otherMenu->addSubmenu('New');
$newMenu->addLink('Stuff', '/stuff');

$page->addWidget('pmHeader', 'menuBar', $menu);

$footerNav = new FooterNav('Footer nav');

// Add links to the first column
$footerNav->addHeading(1, 'Links');
$footerNav->addLink(1, 'Home', '/');
$footerNav->addLink(1, 'About Us', '/about');

// Add links to the second column
$footerNav->addLink(2, 'Contact', '/contact');
$footerNav->addLink(2, 'Privacy Policy', '/privacy');

// Add links to the third column
$footerNav->addLink(3, 'Terms and Conditions', '/terms');
$footerNav->addLink(3, 'Blog', '/blog');

$page->addWidget('pmFooter', 'footerNav', $footerNav);

echo $page->render();
