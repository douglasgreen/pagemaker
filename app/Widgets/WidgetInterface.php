<?php

namespace PageMaker\Widgets;

interface WidgetInterface
{
    public function setName(string $name): void;
    public function setVersion(string $version): void;
    public function setScript(string $name, string $src): void;
    public function setStyle(string $name, string $href): void;

    public function getName(): string;
    public function getVersion(): string;
    public function getScripts(): array;
    public function getStyles(): array;

    public function render(): string;
}
