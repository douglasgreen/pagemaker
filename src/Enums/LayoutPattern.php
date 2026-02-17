<?php

namespace DouglasGreen\PageMaker\Enums;

/**
 * Enum representing different page layout patterns.
 */
enum LayoutPattern: string
{
    /**
     * Return the Twig template name for this pattern.
     */
    public function templateName(): string
    {
        return 'layouts/' . $this->value . '.html.twig';
    }

    case HOLY_GRAIL = 'holy_grail';

    case OFFCANVAS_LEFT = 'offcanvas_left';

    case OFFCANVAS_RIGHT = 'offcanvas_right';

    case STACKED = 'stacked';

    case FIXED_SIDEBAR = 'fixed_sidebar';

    case PARTIALLY_COLLAPSING = 'partially_collapsing';

    case ACCORDION_SIDEBAR = 'accordion_sidebar';

    case OVERLAY_DRAWER = 'overlay_drawer';

    case MINI_ICON_SIDEBAR = 'mini_icon_sidebar';
}
