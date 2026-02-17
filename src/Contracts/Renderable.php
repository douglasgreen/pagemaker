<?php

namespace DouglasGreen\PageMaker\Contracts;

/**
 * Interface for all renderable components.
 */
interface Renderable
{
    /**
     * Return the component as an HTML string.
     */
    public function render(): string;

    /**
     * Allow echo / string coercion.
     */
    public function __toString(): string;
}
