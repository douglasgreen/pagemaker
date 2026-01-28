# PageMaker

## Pattern-Specific Behaviors

| Pattern | Mobile ($<992$px) | Tablet ($\geq992$px) | Implementation Detail |
|---------|-------------------|----------------------|------------------------|
| **HOLY_GRAIL** | Single column, sidebars hidden (`d-none`) | 3-column grid | `col-lg-* d-none d-lg-block` for asides |
| **OFFCANVAS_LEFT** | Single column, hamburger toggles left drawer | Left sidebar visible, main expanded | `offcanvas-lg offcanvas-start` wraps left nav |
| **STACKED** | Single column, sidebars below main | 3-column with source order manipulation | `order-lg-*` classes push Main to center visually while keeping it first in DOM |

## Key Design Decisions

1. **Flexible Content**: All section setters accept `string|Renderable|callable`, allowing raw HTML, component objects, or lazy-evaluated closures.
2. **Breakpoint Configuration**: The `setLayout()` method accepts any of the six Bootstrap breakpoints to control when sidebars appear/disappear.
3. **Automatic Grid Validation**: `setColumnWidths()` validates that columns sum to 12.
4. **Asset Positions**: JavaScript can be placed in `<head>` (for analytics) or end of `<body>` (for performance).
5. **Type Safety**: Enums prevent invalid layout types or breakpoint strings.
6. **Extensibility**: The `Renderable` interface allows you to create custom components (e.g., `DataTable`, `ChartCard`) that integrate seamlessly.
