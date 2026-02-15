<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker;

enum MenuStyle
{
    case NAVBAR;   // Horizontal with dropdowns

    case SIDEBAR;  // Vertical flex-column
}
