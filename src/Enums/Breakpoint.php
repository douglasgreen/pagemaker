<?php

namespace DouglasGreen\PageMaker\Enums;

/**
 * Bootstrap 5.3 breakpoint tiers.
 */
enum Breakpoint: string
{
    /**
     * Pixel value at which this breakpoint activates.
     */
    public function minWidth(): int
    {
        return match ($this) {
            self::XS => 0,
            self::SM => 576,
            self::MD => 768,
            self::LG => 992,
            self::XL => 1200,
            self::XXL => 1400,
        };
    }

    /**
     * Return the Bootstrap class infix (e.g. "-lg").
     * Empty string for XS.
     */
    public function infix(): string
    {
        return $this->value !== '' ? '-' . $this->value : '';
    }

    case XS = '';      // <576px – no infix

    case SM = 'sm';    // ≥576px

    case MD = 'md';    // ≥768px

    case LG = 'lg';    // ≥992px

    case XL = 'xl';    // ≥1200px

    case XXL = 'xxl';  // ≥1400px
}
