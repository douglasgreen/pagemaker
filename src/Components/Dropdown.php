<?php
namespace App\Layout\Components;

class Dropdown implements MenuItem {
    private array $items = [];
    
    public function __construct(
        private readonly string $label,
        private string $id = ''
    ) {
        $this->id = $id ?: 'dropdown-' . uniqid();
    }
    
    public function addItem(MenuItem $item): self {
        $this->items[] = $item;
        return $this;
    }
    
    public function render(): string {
        ob_start();
        ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="<?= $this->id ?>" 
               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= htmlspecialchars($this->label) ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="<?= $this->id ?>">
                <?php foreach ($this->items as $item): ?>
                <li><?= $item->render() ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php
        return ob_get_clean();
    }
}
