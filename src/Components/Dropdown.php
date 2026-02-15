<?php

namespace DouglasGreen\PageMaker\Components;

class Dropdown implements MenuItem
{
    /** @var array<int, MenuItem> */
    private array $items = [];

    public function __construct(
        private readonly string $label,
        private string $id = '',
    ) {
        $this->id = $id ?: 'dropdown-' . uniqid();
    }

    public function addItem(MenuItem $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    public function render(): string
    {
        ob_start();
        ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"
               href="#"
               id="<?= htmlspecialchars($this->id, ENT_QUOTES, 'UTF-8'); ?>"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false"
               aria-haspopup="true">
                <?= htmlspecialchars($this->label, ENT_QUOTES, 'UTF-8'); ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="<?= htmlspecialchars($this->id, ENT_QUOTES, 'UTF-8'); ?>">
                <?php foreach ($this->items as $item): ?>
                <li><?= $item->render(); ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php
        return ob_get_clean() ?: '';
    }
}
