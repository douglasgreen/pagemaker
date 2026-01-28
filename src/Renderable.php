<?php
namespace App\Layout;

interface Renderable {
    public function render(): string;
}
