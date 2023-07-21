<?php

namespace PageMaker\Widget;

interface WidgetInterface
{
    public function getClass(): string;
    public function getName(): string;
    public function getVersion(): string;
    public function getScripts(): array;
    public function getStyles(): array;
    public function getTag(): string;

    public function render(): string;
}
