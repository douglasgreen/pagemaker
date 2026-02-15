<?php

declare(strict_types=1);

namespace App\Layout;

enum MenuStyle
{
    case NAVBAR;   // Horizontal with dropdowns

    case SIDEBAR;  // Vertical flex-column
}
