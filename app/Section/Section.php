<?php

namespace PageMaker\Section;

use Exception;

class Section
{
    protected static $validTags = [
        'article',
        'aside',
        'nav',
        'section',
    ];

    protected $widgets = [];
    protected $class;
    protected $tag;

    public function __construct(string $tag, string $class)
    {
        $this->tag = strtolower($tag);
        if (!in_array($this->tag, self::$validTags)) {
            throw new Exception('Bad tag');
        }
    }

    public function addWidget(Widget $widget): void
    {
        $this->widget[] = $widget;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getWidgets(): array
    {
        return $this->widgets;
    }
}
