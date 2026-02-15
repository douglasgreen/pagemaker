<?php

declare(strict_types=1);

namespace App\Layout;

enum LayoutType
{
    case HOLY_GRAIL;      // Sidebars hidden on mobile (d-none)

    case OFFCANVAS_LEFT;  // Left nav becomes slide-out drawer

    case STACKED;         // Sidebars stack below main on mobile
}
