<?php

declare(strict_types=1);

namespace DouglasGreen\PageMaker\Enums;

/**
 * Enum representing where assets should be placed in the HTML document.
 */
enum AssetPosition: string
{
    case HEAD = 'head';              // Inside <head>

    case BODY_START = 'body_start'; // Immediately after <body>

    case BODY_END = 'body_end';     // Before </body>
}
