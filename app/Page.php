<?php

namespace PageMaker;

/*
 * @class Page builder
 */
class Page
{
    /** @var Head */
    protected $head;

    /** @var Body */
    protected $body;

    /** @var string Language */
    protected $lang = 'en';

    /**
     * Set the page title.
     */
    public function __construct(Head $head, Body $body)
    {
        $this->head = $head;
        $this->body = $body;
    }

    public function setLanguage(string $lang): void
    {
        $this->lang = $lang;
    }

    public function render(): string
    {
        $output = "<!DOCTYPE html>\n";
        $output .= "<html lang='$this->lang'>\n";
        $output .= $this->header->render();
        $output .= $this->body->render();
        $output .= "</html>\n";
        return $output;
    }
}
