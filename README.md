# PageMaker — Complete Specification

A mobile-first, responsive page layout system built on **Bootstrap 5.3**, **PHP 8.2+**, and the Twig templating engine. This document specifies every class, enum, interface, template, and markup pattern required to build, configure, and render full page layouts from PHP.

---

## Table of Contents

1. [Architecture Overview](#1-architecture-overview)
2. [Core Interfaces and Enums](#2-core-interfaces-and-enums)
3. [The PageMaker Class](#3-the-pagemaker-class)
4. [Layout Patterns](#4-layout-patterns)
5. [Structural Sections](#5-structural-sections)
6. [Interactive Widgets & UI Components](#6-interactive-widgets--ui-components)
7. [Grid System & Breakpoint Reference](#7-grid-system--breakpoint-reference)
8. [Asset Management](#8-asset-management)
9. [Template Specifications](#9-template-specifications)
10. [Complete PHP Class Listing](#10-complete-php-class-listing)
11. [Usage Examples](#11-usage-examples)

---

## 1. Architecture Overview

### 1.1 Design Philosophy

PageMaker treats a web page as a **composition of structural sections** (header, footer, left sidebar, right sidebar, main content) arranged according to a named **layout pattern**. Every section accepts content as `string|Renderable|callable`, giving consumers three ways to populate any slot:

| Content Type | Example | When to Use |
|---|---|---|
| `string` | `'<h1>Hello</h1>'` | Static HTML or simple text |
| `Renderable` | `new Breadcrumb($items)` | Reusable component objects |
| `callable` | `fn() => $twig->render(...)` | Lazy evaluation, expensive queries |

The system is **mobile-first**: every template starts with the smallest-viewport layout and layers on complexity at wider breakpoints using Bootstrap's responsive utilities ([weweb.io](https://www.weweb.io/blog/how-to-build-a-responsive-web-app-guide)).

### 1.2 Technology Stack

| Layer | Technology | Role |
|---|---|---|
| Runtime | PHP 8.2+ | Class model, enums, interfaces |
| Templates | Twig 3.x | HTML generation |
| CSS Framework | Bootstrap 5.3.x | Grid, utilities, components |
| Icons | Bootstrap Icons 1.11+ | Sidebar/icon-strip icons |
| JavaScript | Bootstrap 5.3 bundle (Popper included) | Offcanvas, collapse, dropdowns |

### 1.3 Directory Structure

```
pagemaker/
├── src/
│   ├── Enums/
│   │   ├── LayoutPattern.php
│   │   ├── Breakpoint.php
│   │   └── AssetPosition.php
│   ├── Contracts/
│   │   └── Renderable.php
│   ├── Components/
│   │   ├── Navbar.php
│   │   ├── Sidebar.php
│   │   ├── Breadcrumb.php
│   │   ├── TabSet.php
│   │   ├── Accordion.php
│   │   ├── Modal.php
│   │   ├── Carousel.php
│   │   ├── Footer.php
│   │   ├── HeroSection.php
│   │   └── Form.php
│   ├── Assets/
│   │   └── AssetManager.php
│   └── PageMaker.php
├── templates/
│   ├── base.html.twig
│   ├── layouts/
│   │   ├── holy_grail.html.twig
│   │   ├── offcanvas_left.html.twig
│   │   ├── offcanvas_right.html.twig
│   │   ├── stacked.html.twig
│   │   ├── fixed_sidebar.html.twig
│   │   ├── partially_collapsing.html.twig
│   │   ├── accordion_sidebar.html.twig
│   │   ├── overlay_drawer.html.twig
│   │   └── mini_icon_sidebar.html.twig
│   └── components/
│       ├── navbar.html.twig
│       ├── sidebar.html.twig
│       ├── breadcrumb.html.twig
│       ├── tabset.html.twig
│       ├── accordion.html.twig
│       ├── modal.html.twig
│       ├── carousel.html.twig
│       ├── footer.html.twig
│       ├── hero.html.twig
│       └── form.html.twig
├── public/
│   └── css/
│       └── pagemaker.css       (custom overrides)
└── tests/
```

---

## 2. Core Interfaces and Enums

### 2.1 `Renderable` Interface

Every component that can fill a layout slot implements this interface.

```php
<?php

namespace PageMaker\Contracts;

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
```

### 2.2 `LayoutPattern` Enum

```php
<?php

namespace PageMaker\Enums;

enum LayoutPattern: string
{
    case HOLY_GRAIL            = 'holy_grail';
    case OFFCANVAS_LEFT        = 'offcanvas_left';
    case OFFCANVAS_RIGHT       = 'offcanvas_right';
    case STACKED               = 'stacked';
    case FIXED_SIDEBAR         = 'fixed_sidebar';
    case PARTIALLY_COLLAPSING  = 'partially_collapsing';
    case ACCORDION_SIDEBAR     = 'accordion_sidebar';
    case OVERLAY_DRAWER        = 'overlay_drawer';
    case MINI_ICON_SIDEBAR     = 'mini_icon_sidebar';

    /** Return the Twig template name for this pattern. */
    public function templateName(): string
    {
        return 'layouts/' . $this->value . '.html.twig';
    }
}
```

### 2.3 `Breakpoint` Enum

Bootstrap 5.3 defines six breakpoint tiers ([reintech.io](https://reintech.io/blog/bootstrap-5-grid-system-advanced-layout-techniques)). PageMaker uses them to control when sidebars become visible.

```php
<?php

namespace PageMaker\Enums;

enum Breakpoint: string
{
    case XS  = '';      // <576px  – no infix
    case SM  = 'sm';    // ≥576px
    case MD  = 'md';    // ≥768px
    case LG  = 'lg';    // ≥992px
    case XL  = 'xl';    // ≥1200px
    case XXL = 'xxl';   // ≥1400px

    /** Pixel value at which this breakpoint activates. */
    public function minWidth(): int
    {
        return match ($this) {
            self::XS  => 0,
            self::SM  => 576,
            self::MD  => 768,
            self::LG  => 992,
            self::XL  => 1200,
            self::XXL => 1400,
        };
    }

    /** Return the Bootstrap class infix (e.g. "-lg"). Empty string for XS. */
    public function infix(): string
    {
        return $this->value !== '' ? '-' . $this->value : '';
    }
}
```

### 2.4 `AssetPosition` Enum

```php
<?php

namespace PageMaker\Enums;

enum AssetPosition: string
{
    case HEAD       = 'head';        // Inside <head>
    case BODY_START = 'body_start';  // Immediately after <body>
    case BODY_END   = 'body_end';    // Before </body>
}
```

---

## 3. The `PageMaker` Class

This is the central builder. It collects configuration, resolves content slots, and delegates rendering to the template engine.

### 3.1 Full Class Definition

```php
<?php

namespace PageMaker;

use PageMaker\Contracts\Renderable;
use PageMaker\Enums\AssetPosition;
use PageMaker\Enums\Breakpoint;
use PageMaker\Enums\LayoutPattern;
use PageMaker\Assets\AssetManager;
use InvalidArgumentException;

class PageMaker
{
    // ── Metadata ──────────────────────────────────
    private string $title = '';
    private string $lang = 'en';
    private array  $metaTags = [];
    private string $charset = 'UTF-8';
    private string $viewport = 'width=device-width, initial-scale=1';

    // ── Layout ────────────────────────────────────
    private LayoutPattern $pattern = LayoutPattern::HOLY_GRAIL;
    private Breakpoint $sidebarBreakpoint = Breakpoint::LG;
    private array $columnWidths = [3, 6, 3]; // [left, main, right]

    // ── Content slots ─────────────────────────────
    private string|Renderable|callable|null $header      = null;
    private string|Renderable|callable|null $footer      = null;
    private string|Renderable|callable|null $leftSidebar = null;
    private string|Renderable|callable|null $rightSidebar = null;
    private string|Renderable|callable|null $mainContent = null;
    private string|Renderable|callable|null $heroSection = null;
    private string|Renderable|callable|null $breadcrumb  = null;

    // ── Extras ────────────────────────────────────
    private string $bodyClass = '';
    private string $containerId = 'page-wrapper';
    private bool   $fluidContainer = false;

    // ── Assets ────────────────────────────────────
    private AssetManager $assets;

    // ── Template engine callback ──────────────────
    /** @var callable(string $template, array $context): string */
    private $renderer;

    /**
     * @param callable(string $template, array $context): string $renderer
     *        A function that accepts a template name and context array,
     *        returning rendered HTML. Wrap your Twig call here.
     */
    public function __construct(callable $renderer)
    {
        $this->renderer = $renderer;
        $this->assets = new AssetManager();
    }

    // ━━ Metadata setters ━━━━━━━━━━━━━━━━━━━━━━━━━

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function setLang(string $lang): static
    {
        $this->lang = $lang;
        return $this;
    }

    public function setCharset(string $charset): static
    {
        $this->charset = $charset;
        return $this;
    }

    public function setViewport(string $viewport): static
    {
        $this->viewport = $viewport;
        return $this;
    }

    public function addMeta(string $name, string $content): static
    {
        $this->metaTags[$name] = $content;
        return $this;
    }

    // ━━ Layout setters ━━━━━━━━━━━━━━━━━━━━━━━━━━━

    public function setLayout(
        LayoutPattern $pattern,
        Breakpoint $sidebarBreakpoint = Breakpoint::LG
    ): static {
        $this->pattern = $pattern;
        $this->sidebarBreakpoint = $sidebarBreakpoint;
        return $this;
    }

    /**
     * Set Bootstrap grid column widths for [left, main, right].
     * Must sum to 12. For layouts without a particular sidebar,
     * pass 0 for that column.
     *
     * @param int $left   0–12
     * @param int $main   1–12
     * @param int $right  0–12
     * @throws InvalidArgumentException
     */
    public function setColumnWidths(int $left, int $main, int $right): static
    {
        $sum = $left + $main + $right;
        if ($sum !== 12) {
            throw new InvalidArgumentException(
                "Column widths must sum to 12; got {$left}+{$main}+{$right}={$sum}."
            );
        }
        if ($main < 1) {
            throw new InvalidArgumentException(
                "Main column must be at least 1; got {$main}."
            );
        }
        $this->columnWidths = [$left, $main, $right];
        return $this;
    }

    // ━━ Content setters ━━━━━━━━━━━━━━━━━━━━━━━━━━

    public function setHeader(string|Renderable|callable $content): static
    {
        $this->header = $content;
        return $this;
    }

    public function setFooter(string|Renderable|callable $content): static
    {
        $this->footer = $content;
        return $this;
    }

    public function setLeftSidebar(string|Renderable|callable $content): static
    {
        $this->leftSidebar = $content;
        return $this;
    }

    public function setRightSidebar(string|Renderable|callable $content): static
    {
        $this->rightSidebar = $content;
        return $this;
    }

    public function setMainContent(string|Renderable|callable $content): static
    {
        $this->mainContent = $content;
        return $this;
    }

    public function setHeroSection(string|Renderable|callable $content): static
    {
        $this->heroSection = $content;
        return $this;
    }

    public function setBreadcrumb(string|Renderable|callable $content): static
    {
        $this->breadcrumb = $content;
        return $this;
    }

    // ━━ Extras ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

    public function setBodyClass(string $class): static
    {
        $this->bodyClass = $class;
        return $this;
    }

    public function setContainerId(string $id): static
    {
        $this->containerId = $id;
        return $this;
    }

    public function useFluidContainer(bool $fluid = true): static
    {
        $this->fluidContainer = $fluid;
        return $this;
    }

    // ━━ Asset pass-through ━━━━━━━━━━━━━━━━━━━━━━━

    public function assets(): AssetManager
    {
        return $this->assets;
    }

    // ━━ Resolve & Render ━━━━━━━━━━━━━━━━━━━━━━━━━

    /**
     * Evaluate a content slot to a string.
     */
    private function resolve(string|Renderable|callable|null $slot): string
    {
        if ($slot === null) {
            return '';
        }
        if (is_string($slot)) {
            return $slot;
        }
        if ($slot instanceof Renderable) {
            return $slot->render();
        }
        if (is_callable($slot)) {
            $result = ($slot)();
            return $result instanceof Renderable ? $result->render() : (string) $result;
        }
        return '';
    }

    /**
     * Build the full template context array.
     */
    private function buildContext(): array
    {
        $bp = $this->sidebarBreakpoint;

        return [
            // Metadata
            'title'       => $this->title,
            'lang'        => $this->lang,
            'charset'     => $this->charset,
            'viewport'    => $this->viewport,
            'meta_tags'   => $this->metaTags,

            // Layout
            'pattern'            => $this->pattern->value,
            'breakpoint'         => $bp->value,
            'breakpoint_infix'   => $bp->infix(),
            'col_left'           => $this->columnWidths[0],
            'col_main'           => $this->columnWidths[1],
            'col_right'          => $this->columnWidths[2],

            // Resolved content
            'header'        => $this->resolve($this->header),
            'footer'        => $this->resolve($this->footer),
            'left_sidebar'  => $this->resolve($this->leftSidebar),
            'right_sidebar' => $this->resolve($this->rightSidebar),
            'main_content'  => $this->resolve($this->mainContent),
            'hero_section'  => $this->resolve($this->heroSection),
            'breadcrumb'    => $this->resolve($this->breadcrumb),

            // Extras
            'body_class'      => $this->bodyClass,
            'container_id'    => $this->containerId,
            'fluid_container' => $this->fluidContainer,

            // Assets
            'head_assets'       => $this->assets->render(AssetPosition::HEAD),
            'body_start_assets' => $this->assets->render(AssetPosition::BODY_START),
            'body_end_assets'   => $this->assets->render(AssetPosition::BODY_END),
        ];
    }

    /**
     * Render the final HTML page.
     */
    public function render(): string
    {
        return ($this->renderer)(
            $this->pattern->templateName(),
            $this->buildContext()
        );
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
```

### 3.2 Column Width Presets

For convenience, provide named presets:

```php
// Inside PageMaker or as a helper
public function usePreset(string $preset): static
{
    return match ($preset) {
        'left-only'    => $this->setColumnWidths(3, 9, 0),
        'right-only'   => $this->setColumnWidths(0, 9, 3),
        'both-narrow'  => $this->setColumnWidths(2, 8, 2),
        'both-wide'    => $this->setColumnWidths(3, 6, 3),
        'both-unequal' => $this->setColumnWidths(3, 7, 2),
        'no-sidebars'  => $this->setColumnWidths(0, 12, 0),
        default        => throw new InvalidArgumentException("Unknown preset: {$preset}"),
    };
}
```

---

## 4. Layout Patterns

Each pattern defines **how the structural sections behave at the mobile breakpoint vs. the configured sidebar breakpoint**. All patterns share the same base template (`base.html.twig`) and override only the body block.

### 4.1 Pattern Behavior Matrix

| Pattern | Mobile (below $bp) | At/Above $bp | Key Bootstrap Classes | Sidebars Used |
|---|---|---|---|---|
| **HOLY_GRAIL** | Single column; sidebars hidden | 3-column grid | `d-none d-{bp}-block`, `col-{bp}-*` | Left, Right |
| **OFFCANVAS_LEFT** | Hamburger toggles left drawer | Left sidebar visible inline | `offcanvas-{bp} offcanvas-start` | Left |
| **OFFCANVAS_RIGHT** | Hamburger toggles right drawer | Right sidebar visible inline | `offcanvas-{bp} offcanvas-end` | Right |
| **STACKED** | Single column; sidebars stack below main | 3-column; DOM order rearranged | `order-{bp}-*` | Left, Right |
| **FIXED_SIDEBAR** | Sidebar collapses to mini icon strip | Fixed-position sidebar + scrollable main | `position-fixed`, `sidebar-mini` | Left |
| **PARTIALLY_COLLAPSING** | Sidebar shows icons only (always visible) | Full sidebar with labels | `sidebar-narrow` ↔ `sidebar-wide` | Left |
| **ACCORDION_SIDEBAR** | Sidebar content in accordion | Expanded multi-level nav | Bootstrap `accordion` inside sidebar | Left |
| **OVERLAY_DRAWER** | Full-screen overlay drawer | Sidebar as normal grid column | `offcanvas` + `offcanvas-backdrop` | Left |
| **MINI_ICON_SIDEBAR** | Narrow icon strip, expand on tap | Full sidebar with text + icons | `sidebar-mini`, `d-none d-{bp}-inline` | Left |

> The variable $bp above refers to `sidebarBreakpoint` — configurable via `setLayout()`.

### 4.2 HOLY_GRAIL

The classic three-column layout. Sidebars are completely hidden on mobile and appear as grid columns at the configured breakpoint ([reintech.io](https://reintech.io/blog/bootstrap-5-grid-system-advanced-layout-techniques)).

**Responsive behavior:**

- **Below** $bp: Single column. `<main>` spans 12 columns. Both sidebars have `d-none`.
- **At/above** $bp: Three columns. Left sidebar = `col-{bp}-{left}`, main = `col-{bp}-{main}`, right = `col-{bp}-{right}`.

**Template:** `layouts/holy_grail.html.twig`

```twig
{% extends "base.html.twig" %}

{% block body_content %}
{# --- Hero (optional, full-width) --- #}
{% if hero_section %}
<section class="pm-hero">
    {{ hero_section|raw }}
</section>
{% endif %}

{# --- Breadcrumb (optional) --- #}
{% if breadcrumb %}
<nav aria-label="breadcrumb" class="pm-breadcrumb-bar">
    {{ breadcrumb|raw }}
</nav>
{% endif %}

<div class="row g-0">
    {# LEFT SIDEBAR #}
    {% if left_sidebar and col_left > 0 %}
    <aside class="col{{ breakpoint_infix }}-{{ col_left }} d-none d-{{ breakpoint }}-block pm-sidebar pm-sidebar-left"
           role="complementary" aria-label="Left sidebar">
        {{ left_sidebar|raw }}
    </aside>
    {% endif %}

    {# MAIN CONTENT #}
    <main class="col-12 col{{ breakpoint_infix }}-{{ col_main }} pm-main"
          role="main" id="main-content">
        {{ main_content|raw }}
    </main>

    {# RIGHT SIDEBAR #}
    {% if right_sidebar and col_right > 0 %}
    <aside class="col{{ breakpoint_infix }}-{{ col_right }} d-none d-{{ breakpoint }}-block pm-sidebar pm-sidebar-right"
           role="complementary" aria-label="Right sidebar">
        {{ right_sidebar|raw }}
    </aside>
    {% endif %}
</div>
{% endblock %}
```

### 4.3 OFFCANVAS_LEFT

Left sidebar content lives inside a Bootstrap **Offcanvas** component. On mobile it slides in from the left when a hamburger button is clicked. At the breakpoint it renders inline as a grid column ([getbootstrap.com](https://getbootstrap.com/docs/5.3/examples/sidebars)).

**Template:** `layouts/offcanvas_left.html.twig`

```twig
{% extends "base.html.twig" %}

{% block body_content %}
{% if hero_section %}
<section class="pm-hero">{{ hero_section|raw }}</section>
{% endif %}

{% if breadcrumb %}
<nav aria-label="breadcrumb" class="pm-breadcrumb-bar">{{ breadcrumb|raw }}</nav>
{% endif %}

{# Hamburger toggle — visible below breakpoint #}
<button class="btn btn-outline-secondary d-{{ breakpoint }}-none mb-3"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#pm-offcanvas-left"
        aria-controls="pm-offcanvas-left"
        aria-label="Toggle navigation">
    <i class="bi bi-list"></i> Menu
</button>

<div class="row g-0">
    {# LEFT SIDEBAR inside responsive offcanvas #}
    <div class="offcanvas{{ breakpoint_infix }} offcanvas-start col{{ breakpoint_infix }}-{{ col_left }} pm-sidebar pm-sidebar-left"
         tabindex="-1"
         id="pm-offcanvas-left"
         aria-labelledby="pm-offcanvas-left-label">
        <div class="offcanvas-header d-{{ breakpoint }}-none">
            <h5 class="offcanvas-title" id="pm-offcanvas-left-label">Navigation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            {{ left_sidebar|raw }}
        </div>
    </div>

    {# MAIN CONTENT #}
    <main class="col-12 col{{ breakpoint_infix }}-{{ col_main }} pm-main"
          role="main" id="main-content">
        {{ main_content|raw }}
    </main>
</div>
{% endblock %}
```

### 4.4 OFFCANVAS_RIGHT

Mirror of OFFCANVAS_LEFT but the drawer opens from the right.

**Template:** `layouts/offcanvas_right.html.twig`

```twig
{% extends "base.html.twig" %}

{% block body_content %}
{% if hero_section %}
<section class="pm-hero">{{ hero_section|raw }}</section>
{% endif %}

{% if breadcrumb %}
<nav aria-label="breadcrumb" class="pm-breadcrumb-bar">{{ breadcrumb|raw }}</nav>
{% endif %}

<button class="btn btn-outline-secondary d-{{ breakpoint }}-none mb-3"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#pm-offcanvas-right"
        aria-controls="pm-offcanvas-right"
        aria-label="Toggle sidebar">
    <i class="bi bi-layout-sidebar-reverse"></i> Sidebar
</button>

<div class="row g-0">
    {# MAIN #}
    <main class="col-12 col{{ breakpoint_infix }}-{{ col_main }} pm-main"
          role="main" id="main-content">
        {{ main_content|raw }}
    </main>

    {# RIGHT SIDEBAR #}
    <div class="offcanvas{{ breakpoint_infix }} offcanvas-end col{{ breakpoint_infix }}-{{ col_right }} pm-sidebar pm-sidebar-right"
         tabindex="-1"
         id="pm-offcanvas-right"
         aria-labelledby="pm-offcanvas-right-label">
        <div class="offcanvas-header d-{{ breakpoint }}-none">
            <h5 class="offcanvas-title" id="pm-offcanvas-right-label">Sidebar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            {{ right_sidebar|raw }}
        </div>
    </div>
</div>
{% endblock %}
```

### 4.5 STACKED

On mobile, content stacks in a single column with **main first** in the source order (for SEO and accessibility). At the breakpoint, `order-{bp}-*` classes visually rearrange columns into left–main–right ([reintech.io](https://reintech.io/blog/bootstrap-5-grid-system-advanced-layout-techniques)).

**Template:** `layouts/stacked.html.twig`

```twig
{% extends "base.html.twig" %}

{% block body_content %}
{% if hero_section %}
<section class="pm-hero">{{ hero_section|raw }}</section>
{% endif %}

{% if breadcrumb %}
<nav aria-label="breadcrumb" class="pm-breadcrumb-bar">{{ breadcrumb|raw }}</nav>
{% endif %}

<div class="row g-0">
    {# MAIN is first in DOM for mobile stacking & SEO #}
    <main class="col-12 col{{ breakpoint_infix }}-{{ col_main }} order{{ breakpoint_infix }}-2 pm-main"
          role="main" id="main-content">
        {{ main_content|raw }}
    </main>

    {# LEFT SIDEBAR — appears below main on mobile, left on desktop #}
    {% if left_sidebar and col_left > 0 %}
    <aside class="col-12 col{{ breakpoint_infix }}-{{ col_left }} order{{ breakpoint_infix }}-1 pm-sidebar pm-sidebar-left"
           role="complementary" aria-label="Left sidebar">
        {{ left_sidebar|raw }}
    </aside>
    {% endif %}

    {# RIGHT SIDEBAR — appears below left sidebar on mobile, right on desktop #}
    {% if right_sidebar and col_right > 0 %}
    <aside class="col-12 col{{ breakpoint_infix }}-{{ col_right }} order{{ breakpoint_infix }}-3 pm-sidebar pm-sidebar-right"
           role="complementary" aria-label="Right sidebar">
        {{ right_sidebar|raw }}
    </aside>
    {% endif %}
</div>
{% endblock %}
```

### 4.6 FIXED_SIDEBAR

The left sidebar is **position-fixed** and scrolls independently of the main content. On mobile it collapses to a narrow icon strip (`sidebar-mini` class) ([getbootstrap.com](https://getbootstrap.com/docs/5.3/examples/sidebars)).

**Template:** `layouts/fixed_sidebar.html.twig`

```twig
{% extends "base.html.twig" %}

{% block body_content %}
{% if hero_section %}
<section class="pm-hero">{{ hero_section|raw }}</section>
{% endif %}

<div class="d-flex" id="pm-fixed-layout">
    {# FIXED SIDEBAR #}
    <aside class="pm-sidebar pm-sidebar-fixed pm-sidebar-left"
           id="pm-sidebar-fixed"
           role="complementary"
           aria-label="Fixed sidebar">
        <div class="d-flex flex-column flex-shrink-0 vh-100 position-fixed overflow-auto"
             style="width: var(--pm-sidebar-width);">
            {{ left_sidebar|raw }}
        </div>
    </aside>

    {# MAIN #}
    <main class="pm-main flex-grow-1" role="main" id="main-content"
          style="margin-left: var(--pm-sidebar-width);">
        {% if breadcrumb %}
        <nav aria-label="breadcrumb" class="pm-breadcrumb-bar">{{ breadcrumb|raw }}</nav>
        {% endif %}
        {{ main_content|raw }}
    </main>
</div>
{% endblock %}
```

**Required CSS variables** (in `pagemaker.css`):

```css
:root {
    --pm-sidebar-width: 280px;
    --pm-sidebar-mini-width: 64px;
}

/* Below breakpoint: collapse to mini */
@media (max-width: 991.98px) {
    .pm-sidebar-fixed > div {
        width: var(--pm-sidebar-mini-width) !important;
    }
    .pm-sidebar-fixed .pm-sidebar-label {
        display: none;
    }
    .pm-main {
        margin-left: var(--pm-sidebar-mini-width) !important;
    }
}
```

### 4.7 PARTIALLY_COLLAPSING

Similar to FIXED_SIDEBAR but the sidebar **always remains visible**. On mobile it narrows to icons only; labels appear on hover via CSS transition or on tap.

**Template:** `layouts/partially_collapsing.html.twig`

```twig
{% extends "base.html.twig" %}

{% block body_content %}
<div class="d-flex" id="pm-partial-layout">
    <aside class="pm-sidebar pm-sidebar-partial pm-sidebar-left d-flex flex-column flex-shrink-0 vh-100 position-sticky top-0 overflow-auto"
           id="pm-sidebar-partial"
           role="complementary"
           aria-label="Navigation sidebar">
        {{ left_sidebar|raw }}
    </aside>

    <main class="pm-main flex-grow-1" role="main" id="main-content">
        {% if breadcrumb %}
        <nav aria-label="breadcrumb" class="pm-breadcrumb-bar">{{ breadcrumb|raw }}</nav>
        {% endif %}
        {{ main_content|raw }}
    </main>
</div>
{% endblock %}
```

**CSS:**

```css
.pm-sidebar-partial {
    width: var(--pm-sidebar-width);
    transition: width 0.25s ease;
}

/* Narrow mode on mobile */
@media (max-width: 991.98px) {
    .pm-sidebar-partial {
        width: var(--pm-sidebar-mini-width);
    }
    .pm-sidebar-partial .pm-sidebar-label {
        opacity: 0;
        width: 0;
        overflow: hidden;
        transition: opacity 0.2s;
    }
    .pm-sidebar-partial:hover {
        width: var(--pm-sidebar-width);
    }
    .pm-sidebar-partial:hover .pm-sidebar-label {
        opacity: 1;
        width: auto;
    }
}
```

### 4.8 ACCORDION_SIDEBAR

The sidebar contains an **accordion** component. Deep navigation hierarchies collapse into sections that expand/collapse on click — especially useful on mobile ([reintech.io](https://reintech.io/blog/navigation-patterns-bootstrap-5-tabs-pills-navbars)).

**Template:** `layouts/accordion_sidebar.html.twig`

```twig
{% extends "base.html.twig" %}

{% block body_content %}
{% if hero_section %}
<section class="pm-hero">{{ hero_section|raw }}</section>
{% endif %}

<div class="row g-0">
    {# ACCORDION SIDEBAR #}
    {% if left_sidebar and col_left > 0 %}
    <aside class="col-12 col{{ breakpoint_infix }}-{{ col_left }} pm-sidebar pm-sidebar-left"
           role="complementary" aria-label="Accordion navigation">
        <div class="accordion" id="pm-sidebar-accordion">
            {{ left_sidebar|raw }}
        </div>
    </aside>
    {% endif %}

    <main class="col-12 col{{ breakpoint_infix }}-{{ col_main }} pm-main"
          role="main" id="main-content">
        {% if breadcrumb %}
        <nav aria-label="breadcrumb" class="pm-breadcrumb-bar">{{ breadcrumb|raw }}</nav>
        {% endif %}
        {{ main_content|raw }}
    </main>
</div>
{% endblock %}
```

### 4.9 OVERLAY_DRAWER

On mobile a **full-screen overlay** drawer covers the content (with a backdrop). On desktop the sidebar renders as a standard grid column.

**Template:** `layouts/overlay_drawer.html.twig`

```twig
{% extends "base.html.twig" %}

{% block body_content %}
{# Toggle button — mobile only #}
<button class="btn btn-dark d-{{ breakpoint }}-none mb-3"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#pm-overlay-drawer"
        aria-controls="pm-overlay-drawer"
        aria-label="Open menu">
    <i class="bi bi-list"></i>
</button>

{# Drawer (offcanvas for mobile, grid col for desktop) #}
<div class="offcanvas offcanvas-start d-{{ breakpoint }}-none"
     data-bs-backdrop="true"
     data-bs-scroll="false"
     tabindex="-1"
     id="pm-overlay-drawer"
     aria-labelledby="pm-overlay-drawer-label">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="pm-overlay-drawer-label">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        {{ left_sidebar|raw }}
    </div>
</div>

<div class="row g-0">
    {# Desktop sidebar #}
    {% if left_sidebar and col_left > 0 %}
    <aside class="d-none d-{{ breakpoint }}-block col{{ breakpoint_infix }}-{{ col_left }} pm-sidebar pm-sidebar-left"
           role="complementary">
        {{ left_sidebar|raw }}
    </aside>
    {% endif %}

    <main class="col-12 col{{ breakpoint_infix }}-{{ col_main }} pm-main"
          role="main" id="main-content">
        {% if breadcrumb %}
        <nav aria-label="breadcrumb" class="pm-breadcrumb-bar">{{ breadcrumb|raw }}</nav>
        {% endif %}
        {{ main_content|raw }}
    </main>
</div>
{% endblock %}
```

### 4.10 MINI_ICON_SIDEBAR

A narrow icon strip is always visible. On mobile only icons show; at the breakpoint text labels appear beside them.

**Template:** `layouts/mini_icon_sidebar.html.twig`

```twig
{% extends "base.html.twig" %}

{% block body_content %}
<div class="d-flex" id="pm-mini-icon-layout">
    <aside class="pm-sidebar pm-sidebar-mini d-flex flex-column flex-shrink-0 vh-100 position-sticky top-0 overflow-auto"
           id="pm-sidebar-mini"
           role="complementary"
           aria-label="Icon sidebar">
        {{ left_sidebar|raw }}
    </aside>

    <main class="pm-main flex-grow-1" role="main" id="main-content">
        {% if breadcrumb %}
        <nav aria-label="breadcrumb" class="pm-breadcrumb-bar">{{ breadcrumb|raw }}</nav>
        {% endif %}
        {{ main_content|raw }}
    </main>
</div>
{% endblock %}
```

**CSS:**

```css
.pm-sidebar-mini {
    width: var(--pm-sidebar-mini-width);
    transition: width 0.3s ease;
}

.pm-sidebar-mini .pm-sidebar-label {
    display: none;
}

/* At breakpoint: expand */
@media (min-width: 992px) {
    .pm-sidebar-mini {
        width: var(--pm-sidebar-width);
    }
    .pm-sidebar-mini .pm-sidebar-label {
        display: inline;
    }
}

/* Expand on hover (all viewports) */
.pm-sidebar-mini:hover {
    width: var(--pm-sidebar-width);
}
.pm-sidebar-mini:hover .pm-sidebar-label {
    display: inline;
}
```

---

## 5. Structural Sections

These are the major semantic areas of every page. Each has a dedicated component class that implements `Renderable`.

### 5.1 Header / Navbar

```php
<?php

namespace PageMaker\Components;

use PageMaker\Contracts\Renderable;

class Navbar implements Renderable
{
    /**
     * @param string              $brandName  Site name
     * @param string              $brandUrl   Link for brand
     * @param string|null         $brandLogo  Optional logo URL
     * @param array<string,string> $items     label => href
     * @param string              $theme      'light'|'dark'
     * @param bool                $fixed      Sticky top?
     * @param string              $breakpoint Collapse breakpoint infix (e.g. 'lg')
     */
    public function __construct(
        private string  $brandName,
        private string  $brandUrl = '/',
        private ?string $brandLogo = null,
        private array   $items = [],
        private string  $theme = 'dark',
        private bool    $fixed = true,
        private string  $breakpoint = 'lg',
    ) {}

    public function render(): string { /* delegate to template */ }
    public function __toString(): string { return $this->render(); }
}
```

**Template:** `components/navbar.html.twig`

```twig
<nav class="navbar navbar-expand-{{ breakpoint }} {% if theme == 'dark' %}navbar-dark bg-dark{% else %}navbar-light bg-light{% endif %}{% if fixed %} sticky-top{% endif %}"
     role="navigation" aria-label="Main navigation">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ brand_url }}">
            {% if brand_logo %}
            <img src="{{ brand_logo }}" alt="{{ brand_name }}" height="30" class="d-inline-block align-text-top me-2">
            {% endif %}
            {{ brand_name }}
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#pm-navbar-collapse"
                aria-controls="pm-navbar-collapse"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="pm-navbar-collapse">
            <ul class="navbar-nav ms-auto mb-2 mb-{{ breakpoint }}-0">
                {% for label, href in items %}
                <li class="nav-item">
                    <a class="nav-link" href="{{ href }}">{{ label }}</a>
                </li>
                {% endfor %}
            </ul>
        </div>
    </div>
</nav>
```

### 5.2 Hero Section

```php
<?php

namespace PageMaker\Components;

use PageMaker\Contracts\Renderable;

class HeroSection implements Renderable
{
    public function __construct(
        private string  $title,
        private string  $subtitle = '',
        private ?string $ctaLabel = null,
        private ?string $ctaUrl = null,
        private ?string $backgroundImage = null,
        private string  $theme = 'dark',   // 'dark' overlay | 'light'
    ) {}

    public function render(): string { /* delegate to template */ }
    public function __toString(): string { return $this->render(); }
}
```

**Template:** `components/hero.html.twig`

```twig
<div class="pm-hero-section p-5 mb-4 rounded-3 text-{{ theme == 'dark' ? 'white' : 'dark' }}"
     {% if background_image %}
     style="background: url('{{ background_image }}') center/cover no-repeat;
            position: relative;"
     {% endif %}>

    {% if background_image and theme == 'dark' %}
    <div style="position:absolute;inset:0;background:rgba(0,0,0,0.55);border-radius:inherit;"></div>
    {% endif %}

    <div class="container-fluid py-5" style="position:relative;z-index:1;">
        <h1 class="display-4 fw-bold">{{ title }}</h1>
        {% if subtitle %}
        <p class="col-md-8 fs-4">{{ subtitle }}</p>
        {% endif %}
        {% if cta_label and cta_url %}
        <a href="{{ cta_url }}" class="btn btn-{{ theme == 'dark' ? 'light' : 'primary' }} btn-lg mt-3">
            {{ cta_label }}
        </a>
        {% endif %}
    </div>
</div>
```

### 5.3 Sidebar

```php
<?php

namespace PageMaker\Components;

use PageMaker\Contracts\Renderable;

class Sidebar implements Renderable
{
    /**
     * @param array<array{icon:string, label:string, href:string, active?:bool, children?:array}> $navItems
     * @param string|null $heading Optional heading above navigation
     */
    public function __construct(
        private array   $navItems = [],
        private ?string $heading = null,
    ) {}

    public function render(): string { /* delegate to template */ }
    public function __toString(): string { return $this->render(); }
}
```

**Template:** `components/sidebar.html.twig`

```twig
{% if heading %}
<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
    <span>{{ heading }}</span>
</h6>
{% endif %}

<ul class="nav nav-pills flex-column mb-auto">
    {% for item in nav_items %}
    <li class="nav-item">
        <a href="{{ item.href }}"
           class="nav-link{% if item.active|default(false) %} active{% endif %}"
           {% if item.active|default(false) %}aria-current="page"{% endif %}>
            <i class="bi bi-{{ item.icon }} me-2"></i>
            <span class="pm-sidebar-label">{{ item.label }}</span>
        </a>

        {# Nested children #}
        {% if item.children|default([]) is not empty %}
        <ul class="nav flex-column ms-3">
            {% for child in item.children %}
            <li class="nav-item">
                <a href="{{ child.href }}" class="nav-link{% if child.active|default(false) %} active{% endif %}">
                    <i class="bi bi-{{ child.icon }} me-2"></i>
                    <span class="pm-sidebar-label">{{ child.label }}</span>
                </a>
            </li>
            {% endfor %}
        </ul>
        {% endif %}
    </li>
    {% endfor %}
</ul>
```

> **Note:** The `<span class="pm-sidebar-label">` wrapper is critical. The MINI_ICON_SIDEBAR, FIXED_SIDEBAR, and PARTIALLY_COLLAPSING patterns hide this span below the breakpoint to achieve icon-only mode.

### 5.4 Footer

```php
<?php

namespace PageMaker\Components;

use PageMaker\Contracts\Renderable;

class Footer implements Renderable
{
    /**
     * @param array<string, array<string,string>> $columns  heading => [label => href]
     * @param string $copyright  e.g. "© 2026 Acme Inc."
     * @param array<string,string> $socialLinks  platform => url
     */
    public function __construct(
        private array  $columns = [],
        private string $copyright = '',
        private array  $socialLinks = [],
    ) {}

    public function render(): string { /* delegate to template */ }
    public function __toString(): string { return $this->render(); }
}
```

**Template:** `components/footer.html.twig`

```twig
<footer class="pm-footer py-5 bg-dark text-light">
    <div class="container">
        <div class="row">
            {% for heading, links in columns %}
            <div class="col-6 col-md-{{ (12 / columns|length)|round(0, 'floor') }}">
                <h5>{{ heading }}</h5>
                <ul class="nav flex-column">
                    {% for label, href in links %}
                    <li class="nav-item mb-2">
                        <a href="{{ href }}" class="nav-link p-0 text-muted">{{ label }}</a>
                    </li>
                    {% endfor %}
                </ul>
            </div>
            {% endfor %}
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between pt-4 mt-4 border-top border-secondary">
            <p class="mb-0 text-muted">{{ copyright }}</p>
            <ul class="list-unstyled d-flex mb-0">
                {% for platform, url in social_links %}
                <li class="ms-3">
                    <a class="text-muted" href="{{ url }}" aria-label="{{ platform }}">
                        <i class="bi bi-{{ platform }}"></i>
                    </a>
                </li>
                {% endfor %}
            </ul>
        </div>
    </div>
</footer>
```

### 5.5 Breadcrumb

```php
<?php

namespace PageMaker\Components;

use PageMaker\Contracts\Renderable;

class Breadcrumb implements Renderable
{
    /**
     * @param array<string,string|null> $items  label => href (null for current/active)
     */
    public function __construct(
        private array $items = [],
    ) {}

    public function render(): string { /* delegate to template */ }
    public function __toString(): string { return $this->render(); }
}
```

**Template:** `components/breadcrumb.html.twig`

```twig
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        {% for label, href in items %}
        {% if href is not null %}
        <li class="breadcrumb-item"><a href="{{ href }}">{{ label }}</a></li>
        {% else %}
        <li class="breadcrumb-item active" aria-current="page">{{ label }}</li>
        {% endif %}
        {% endfor %}
    </ol>
</nav>
```

---

## 6. Interactive Widgets & UI Components

Each widget implements `Renderable` and can be placed in any content slot.

### 6.1 TabSet

Organize related content sections within a single slot ([reintech.io](https://reintech.io/blog/navigation-patterns-bootstrap-5-tabs-pills-navbars)).

```php
<?php

namespace PageMaker\Components;

use PageMaker\Contracts\Renderable;

class TabSet implements Renderable
{
    /**
     * @param array<string,string|Renderable> $tabs  label => content
     * @param string $style  'tabs'|'pills'
     * @param string $orientation  'horizontal'|'vertical'
     * @param string|null $id  Unique ID prefix (auto-generated if null)
     */
    public function __construct(
        private array   $tabs,
        private string  $style = 'tabs',
        private string  $orientation = 'horizontal',
        private ?string $id = null,
    ) {
        $this->id ??= 'pm-tabset-' . bin2hex(random_bytes(4));
    }

    public function render(): string { /* delegate to template */ }
    public function __toString(): string { return $this->render(); }
}
```

**Template:** `components/tabset.html.twig`

```twig
{% set is_vertical = orientation == 'vertical' %}

<div class="{% if is_vertical %}d-flex align-items-start{% endif %}">
    <ul class="nav nav-{{ style }}{% if is_vertical %} flex-column me-3{% endif %} mb-3"
        id="{{ id }}" role="tablist"
        {% if is_vertical %}aria-orientation="vertical"{% endif %}>
        {% for label, content in tabs %}
        {% set tab_id = id ~ '-' ~ loop.index %}
        <li class="nav-item" role="presentation">
            <button class="nav-link{% if loop.first %} active{% endif %}"
                    id="{{ tab_id }}-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#{{ tab_id }}-pane"
                    type="button" role="tab"
                    aria-controls="{{ tab_id }}-pane"
                    aria-selected="{{ loop.first ? 'true' : 'false' }}">
                {{ label }}
            </button>
        </li>
        {% endfor %}
    </ul>

    <div class="tab-content{% if is_vertical %} flex-grow-1{% endif %}" id="{{ id }}-content">
        {% for label, content in tabs %}
        {% set tab_id = id ~ '-' ~ loop.index %}
        <div class="tab-pane fade{% if loop.first %} show active{% endif %}"
             id="{{ tab_id }}-pane" role="tabpanel"
             aria-labelledby="{{ tab_id }}-tab" tabindex="0">
            {{ content is iterable ? '' : content|raw }}
        </div>
        {% endfor %}
    </div>
</div>
```

### 6.2 Accordion

```php
<?php

namespace PageMaker\Components;

use PageMaker\Contracts\Renderable;

class Accordion implements Renderable
{
    /**
     * @param array<string,string|Renderable> $sections  heading => body
     * @param bool $alwaysOpen  Allow multiple open sections
     * @param bool $flush       Remove borders for edge-to-edge look
     * @param string|null $id
     */
    public function __construct(
        private array   $sections,
        private bool    $alwaysOpen = false,
        private bool    $flush = false,
        private ?string $id = null,
    ) {
        $this->id ??= 'pm-accordion-' . bin2hex(random_bytes(4));
    }

    public function render(): string { /* delegate to template */ }
    public function __toString(): string { return $this->render(); }
}
```

**Template:** `components/accordion.html.twig`

```twig
<div class="accordion{% if flush %} accordion-flush{% endif %}" id="{{ id }}">
    {% for heading, body in sections %}
    {% set item_id = id ~ '-item-' ~ loop.index %}
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button{% if not loop.first %} collapsed{% endif %}"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#{{ item_id }}"
                    aria-expanded="{{ loop.first ? 'true' : 'false' }}"
                    aria-controls="{{ item_id }}">
                {{ heading }}
            </button>
        </h2>
        <div id="{{ item_id }}"
             class="accordion-collapse collapse{% if loop.first %} show{% endif %}"
             {% if not always_open %}data-bs-parent="#{{ id }}"{% endif %}>
            <div class="accordion-body">
                {{ body|raw }}
            </div>
        </div>
    </div>
    {% endfor %}
</div>
```

### 6.3 Modal

```php
<?php

namespace PageMaker\Components;

use PageMaker\Contracts\Renderable;

class Modal implements Renderable
{
    /**
     * @param string $title
     * @param string|Renderable $body
     * @param string|null $footerHtml
     * @param string $size  ''|'sm'|'lg'|'xl'|'fullscreen'
     * @param bool $centered
     * @param bool $scrollable
     * @param bool $staticBackdrop
     * @param string|null $id
     */
    public function __construct(
        private string              $title,
        private string|Renderable   $body,
        private ?string             $footerHtml = null,
        private string              $size = '',
        private bool                $centered = true,
        private bool                $scrollable = false,
        private bool                $staticBackdrop = false,
        private ?string             $id = null,
    ) {
        $this->id ??= 'pm-modal-' . bin2hex(random_bytes(4));
    }

    /** Return the trigger button HTML. */
    public function triggerButton(string $label, string $class = 'btn btn-primary'): string
    {
        return sprintf(
            '<button type="button" class="%s" data-bs-toggle="modal" data-bs-target="#%s">%s</button>',
            $class,
            $this->id,
            $label
        );
    }

    public function render(): string { /* delegate to template */ }
    public function __toString(): string { return $this->render(); }
}
```

**Template:** `components/modal.html.twig`

```twig
<div class="modal fade" id="{{ id }}" tabindex="-1"
     aria-labelledby="{{ id }}-label" aria-hidden="true"
     {% if static_backdrop %}data-bs-backdrop="static" data-bs-keyboard="false"{% endif %}>
    <div class="modal-dialog
                {% if size %}modal-{{ size }}{% endif %}
                {% if centered %}modal-dialog-centered{% endif %}
                {% if scrollable %}modal-dialog-scrollable{% endif %}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ id }}-label">{{ title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ body|raw }}
            </div>
            {% if footer_html %}
            <div class="modal-footer">
                {{ footer_html|raw }}
            </div>
            {% endif %}
        </div>
    </div>
</div>
```

### 6.4 Carousel

```php
<?php

namespace PageMaker\Components;

use PageMaker\Contracts\Renderable;

class Carousel implements Renderable
{
    /**
     * @param array<array{src:string, alt:string, caption?:string, description?:string}> $slides
     * @param bool $controls  Show prev/next arrows
     * @param bool $indicators  Show dot indicators
     * @param bool $fade  Use crossfade instead of slide
     * @param int $interval  Auto-play interval in ms (0 = no auto-play)
     * @param string|null $id
     */
    public function __construct(
        private array   $slides,
        private bool    $controls = true,
        private bool    $indicators = true,
        private bool    $fade = false,
        private int     $interval = 5000,
        private ?string $id = null,
    ) {
        $this->id ??= 'pm-carousel-' . bin2hex(random_bytes(4));
    }

    public function render(): string { /* delegate to template */ }
    public function __toString(): string { return $this->render(); }
}
```

**Template:** `components/carousel.html.twig`

```twig
<div id="{{ id }}"
     class="carousel slide{% if fade %} carousel-fade{% endif %}"
     {% if interval > 0 %}data-bs-ride="carousel"{% endif %}>

    {% if indicators %}
    <div class="carousel-indicators">
        {% for slide in slides %}
        <button type="button" data-bs-target="#{{ id }}" data-bs-slide-to="{{ loop.index0 }}"
                {% if loop.first %}class="active" aria-current="true"{% endif %}
                aria-label="Slide {{ loop.index }}"></button>
        {% endfor %}
    </div>
    {% endif %}

    <div class="carousel-inner">
        {% for slide in slides %}
        <div class="carousel-item{% if loop.first %} active{% endif %}"
             {% if interval > 0 %}data-bs-interval="{{ interval }}"{% endif %}>
            <img src="{{ slide.src }}" class="d-block w-100" alt="{{ slide.alt }}">
            {% if slide.caption is defined or slide.description is defined %}
            <div class="carousel-caption d-none d-md-block">
                {% if slide.caption is defined %}<h5>{{ slide.caption }}</h5>{% endif %}
                {% if slide.description is defined %}<p>{{ slide.description }}</p>{% endif %}
            </div>
            {% endif %}
        </div>
        {% endfor %}
    </div>

    {% if controls %}
    <button class="carousel-control-prev" type="button" data-bs-target="#{{ id }}" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#{{ id }}" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    {% endif %}
</div>
```

### 6.5 Form Builder (Minimal)

```php
<?php

namespace PageMaker\Components;

use PageMaker\Contracts\Renderable;

class Form implements Renderable
{
    /**
     * @param string $action  Form action URL
     * @param string $method  HTTP method
     * @param array<array{type:string, name:string, label:string, placeholder?:string,
     *        required?:bool, options?:array, value?:string}> $fields
     * @param string $submitLabel
     * @param bool $csrfToken  Include a CSRF hidden field placeholder
     */
    public function __construct(
        private string $action,
        private string $method = 'POST',
        private array  $fields = [],
        private string $submitLabel = 'Submit',
        private bool   $csrfToken = true,
    ) {}

    public function render(): string { /* delegate to template */ }
    public function __toString(): string { return $this->render(); }
}
```

**Template:** `components/form.html.twig`

```twig
<form action="{{ action }}" method="{{ method }}" class="pm-form">
    {% if csrf_token %}
    <input type="hidden" name="_token" value="{{ csrf_token_value|default('') }}">
    {% endif %}

    {% for field in fields %}
    <div class="mb-3">
        <label for="pm-field-{{ field.name }}" class="form-label">{{ field.label }}</label>

        {% if field.type == 'textarea' %}
        <textarea class="form-control" id="pm-field-{{ field.name }}" name="{{ field.name }}"
                  placeholder="{{ field.placeholder|default('') }}"
                  {% if field.required|default(false) %}required{% endif %}
                  rows="4">{{ field.value|default('') }}</textarea>

        {% elseif field.type == 'select' %}
        <select class="form-select" id="pm-field-{{ field.name }}" name="{{ field.name }}"
                {% if field.required|default(false) %}required{% endif %}>
            {% for optVal, optLabel in field.options|default({}) %}
            <option value="{{ optVal }}"
                    {% if field.value|default('') == optVal %}selected{% endif %}>
                {{ optLabel }}
            </option>
            {% endfor %}
        </select>

        {% elseif field.type == 'checkbox' %}
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="pm-field-{{ field.name }}" name="{{ field.name }}"
                   {% if field.value|default(false) %}checked{% endif %}
                   {% if field.required|default(false) %}required{% endif %}>
            <label class="form-check-label" for="pm-field-{{ field.name }}">{{ field.label }}</label>
        </div>

        {% else %}
        <input type="{{ field.type }}" class="form-control" id="pm-field-{{ field.name }}"
               name="{{ field.name }}"
               placeholder="{{ field.placeholder|default('') }}"
               value="{{ field.value|default('') }}"
               {% if field.required|default(false) %}required{% endif %}>
        {% endif %}
    </div>
    {% endfor %}

    <button type="submit" class="btn btn-primary">{{ submit_label }}</button>
</form>
```

### 6.6 Component Summary Table

| Component | Class | Bootstrap Feature | Typical Slot |
|---|---|---|---|
| **Navbar** | `Navbar` | Navbar + Collapse | `header` |
| **HeroSection** | `HeroSection` | Jumbotron pattern | `heroSection` |
| **Sidebar** | `Sidebar` | Nav pills, flex-column | `leftSidebar` / `rightSidebar` |
| **Footer** | `Footer` | Grid columns, nav | `footer` |
| **Breadcrumb** | `Breadcrumb` | Breadcrumb component | `breadcrumb` |
| **TabSet** | `TabSet` | Tabs / Pills + Tab content | Any content slot |
| **Accordion** | `Accordion` | Accordion / Collapse | Any content slot |
| **Modal** | `Modal` | Modal dialog | Any content slot |
| **Carousel** | `Carousel` | Carousel / Slide | Any content slot |
| **Form** | `Form` | Form controls, validation | Any content slot |

---

## 7. Grid System & Breakpoint Reference

### 7.1 Bootstrap 5.3 Breakpoints

All responsive behaviors in PageMaker are governed by these tiers ([reintech.io](https://reintech.io/blog/bootstrap-5-grid-system-advanced-layout-techniques), [alpharithms.com](https://www.alpharithms.com/boostrap-responsive-page-layout-guide-501916/)):

| Breakpoint | Enum Value | Class Infix | Min Width | Typical Device |
|---|---|---|---|---|
| Extra small | `XS` | *(none)* | $0\text{px}$ | Phones (portrait) |
| Small | `SM` | `-sm` | $\geq 576\text{px}$ | Phones (landscape) |
| Medium | `MD` | `-md` | $\geq 768\text{px}$ | Tablets |
| Large | `LG` | `-lg` | $\geq 992\text{px}$ | Laptops / small desktops |
| Extra large | `XL` | `-xl` | $\geq 1200\text{px}$ | Desktops |
| Extra extra large | `XXL` | `-xxl` | $\geq 1400\text{px}$ | Large desktops / TVs |

### 7.2 Column Arithmetic

Bootstrap uses a **12-column grid**. The `setColumnWidths($left, $main, $right)` method enforces:

$$\text{left} + \text{main} + \text{right} = 12$$

where $\text{main} \geq 1$ and $\text{left}, \text{right} \geq 0$.

**Mobile behavior** (below the sidebar breakpoint): the main column is always `col-12` (full width). Sidebar columns receive responsive class `col-{bp}-{n}` so they only activate at the breakpoint.

### 7.3 Class Generation Logic

For a given `Breakpoint $bp` with infix `$i` and widths `[$l, $m, $r]`:

| Element | Mobile Class | Desktop Class | Visibility (HOLY_GRAIL) |
|---|---|---|---|
| Left sidebar | — | `col{$i}-{$l}` | `d-none d-{$bp}-block` |
| Main content | `col-12` | `col{$i}-{$m}` | Always visible |
| Right sidebar | — | `col{$i}-{$r}` | `d-none d-{$bp}-block` |

For **STACKED**, add `order{$i}-1`, `order{$i}-2`, `order{$i}-3` to control visual order while keeping main first in the DOM ([reintech.io](https://reintech.io/blog/bootstrap-5-grid-system-advanced-layout-techniques)).

---

## 8. Asset Management

### 8.1 `AssetManager` Class

```php
<?php

namespace PageMaker\Assets;

use PageMaker\Enums\AssetPosition;

class AssetManager
{
    /** @var array<string, array{type:string, position:AssetPosition, attributes:array}> */
    private array $assets = [];

    /**
     * Add a CSS stylesheet.
     */
    public function addCss(
        string $href,
        AssetPosition $position = AssetPosition::HEAD,
        array $attributes = [],
    ): static {
        $this->assets[$href] = [
            'type'       => 'css',
            'position'   => $position,
            'attributes' => $attributes,
        ];
        return $this;
    }

    /**
     * Add a JavaScript file.
     */
    public function addJs(
        string $src,
        AssetPosition $position = AssetPosition::BODY_END,
        array $attributes = [],
    ): static {
        $this->assets[$src] = [
            'type'       => 'js',
            'position'   => $position,
            'attributes' => $attributes,
        ];
        return $this;
    }

    /**
     * Add an inline style block.
     */
    public function addInlineCss(
        string $css,
        AssetPosition $position = AssetPosition::HEAD,
    ): static {
        $key = 'inline_css_' . md5($css);
        $this->assets[$key] = [
            'type'       => 'inline_css',
            'content'    => $css,
            'position'   => $position,
            'attributes' => [],
        ];
        return $this;
    }

    /**
     * Add an inline script block.
     */
    public function addInlineJs(
        string $js,
        AssetPosition $position = AssetPosition::BODY_END,
    ): static {
        $key = 'inline_js_' . md5($js);
        $this->assets[$key] = [
            'type'       => 'inline_js',
            'content'    => $js,
            'position'   => $position,
            'attributes' => [],
        ];
        return $this;
    }

    /**
     * Register Bootstrap 5.3 CDN assets (CSS in head, JS bundle at body end).
     */
    public function addBootstrap(string $version = '5.3.3'): static
    {
        $this->addCss(
            "https://cdn.jsdelivr.net/npm/bootstrap@{$version}/dist/css/bootstrap.min.css",
            AssetPosition::HEAD,
            ['crossorigin' => 'anonymous'],
        );
        $this->addJs(
            "https://cdn.jsdelivr.net/npm/bootstrap@{$version}/dist/js/bootstrap.bundle.min.js",
            AssetPosition::BODY_END,
            ['crossorigin' => 'anonymous'],
        );
        return $this;
    }

    /**
     * Register Bootstrap Icons CDN.
     */
    public function addBootstrapIcons(string $version = '1.11.3'): static
    {
        $this->addCss(
            "https://cdn.jsdelivr.net/npm/bootstrap-icons@{$version}/font/bootstrap-icons.min.css",
            AssetPosition::HEAD,
        );
        return $this;
    }

    /**
     * Render all assets for a given position as HTML tags.
     */
    public function render(AssetPosition $position): string
    {
        $html = '';

        foreach ($this->assets as $key => $asset) {
            if ($asset['position'] !== $position) {
                continue;
            }

            $attrs = '';
            foreach ($asset['attributes'] as $name => $value) {
                $attrs .= " {$name}=\"" . htmlspecialchars($value, ENT_QUOTES) . '"';
            }

            $html .= match ($asset['type']) {
                'css'        => "<link rel=\"stylesheet\" href=\"{$key}\"{$attrs}>\n",
                'js'         => "<script src=\"{$key}\"{$attrs}></script>\n",
                'inline_css' => "<style>{$asset['content']}</style>\n",
                'inline_js'  => "<script>{$asset['content']}</script>\n",
                default      => '',
            };
        }

        return $html;
    }
}
```

### 8.2 Default Asset Stack

Every PageMaker page should include at minimum:

| Asset | Position | Purpose |
|---|---|---|
| Bootstrap 5.3 CSS | `HEAD` | Grid, utilities, components |
| Bootstrap Icons CSS | `HEAD` | Sidebar/navigation icons |
| `pagemaker.css` | `HEAD` | Custom CSS variables + overrides |
| Bootstrap 5.3 JS bundle | `BODY_END` | Offcanvas, collapse, modal, etc. |

---

## 9. Template Specifications

### 9.1 Base Template

All layout templates extend this base, which provides the HTML document shell.

**`templates/base.html.twig`**

```twig
<!DOCTYPE html>
<html lang="{{ lang }}">
<head>
    <meta charset="{{ charset }}">
    <meta name="viewport" content="{{ viewport }}">
    {% for name, content in meta_tags %}
    <meta name="{{ name }}" content="{{ content }}">
    {% endfor %}
    <title>{{ title }}</title>

    {# HEAD assets (CSS, analytics, etc.) #}
    {{ head_assets|raw }}
</head>
<body class="{{ body_class }}">
    {{ body_start_assets|raw }}

    {# HEADER #}
    {% if header %}
    <header class="pm-header" role="banner">
        {{ header|raw }}
    </header>
    {% endif %}

    {# MAIN LAYOUT — overridden by each pattern template #}
    <div class="{{ fluid_container ? 'container-fluid' : 'container' }} pm-container"
         id="{{ container_id }}">
        {% block body_content %}{% endblock %}
    </div>

    {# FOOTER #}
    {% if footer %}
    {{ footer|raw }}
    {% endif %}

    {# BODY_END assets (JS) #}
    {{ body_end_assets|raw }}
</body>
</html>
```

### 9.2 Template Variable Reference

Every layout template receives all of these variables from `PageMaker::buildContext()`:

| Variable | Type | Description |
|---|---|---|
| `title` | `string` | HTML `<title>` |
| `lang` | `string` | `<html lang>` attribute |
| `charset` | `string` | Character encoding |
| `viewport` | `string` | Viewport meta content |
| `meta_tags` | `array<string,string>` | Additional `<meta>` tags |
| `pattern` | `string` | Layout pattern value (e.g. `'holy_grail'`) |
| `breakpoint` | `string` | Breakpoint infix value (e.g. `'lg'`) |
| `breakpoint_infix` | `string` | Prefixed infix (e.g. `'-lg'`) |
| `col_left` | `int` | Left sidebar column width (0–11) |
| `col_main` | `int` | Main content column width (1–12) |
| `col_right` | `int` | Right sidebar column width (0–11) |
| `header` | `string` | Resolved header HTML |
| `footer` | `string` | Resolved footer HTML |
| `left_sidebar` | `string` | Resolved left sidebar HTML |
| `right_sidebar` | `string` | Resolved right sidebar HTML |
| `main_content` | `string` | Resolved main content HTML |
| `hero_section` | `string` | Resolved hero HTML |
| `breadcrumb` | `string` | Resolved breadcrumb HTML |
| `body_class` | `string` | Extra `<body>` classes |
| `container_id` | `string` | Wrapper div ID |
| `fluid_container` | `bool` | Use `container-fluid`? |
| `head_assets` | `string` | Pre-rendered `<link>`/`<style>` tags |
| `body_start_assets` | `string` | Pre-rendered tags after `<body>` |
| `body_end_assets` | `string` | Pre-rendered `<script>` tags |

---

## 10. Complete PHP Class Listing

### 10.1 Custom CSS (`public/css/pagemaker.css`)

```css
/* ═══════════════════════════════════════════
   PageMaker – Custom CSS Variables & Overrides
   Requires Bootstrap 5.3+
   ═══════════════════════════════════════════ */

:root {
    /* Sidebar dimensions */
    --pm-sidebar-width: 280px;
    --pm-sidebar-mini-width: 64px;

    /* Transitions */
    --pm-transition-speed: 0.25s;

    /* Z-index layering */
    --pm-z-sidebar: 1030;
    --pm-z-header: 1040;
}

/* ── General ──────────────────────────────── */
.pm-container {
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.pm-main {
    min-height: 60vh;
}

/* ── Sidebar shared styles ────────────────── */
.pm-sidebar {
    background-color: var(--bs-body-bg);
    border-right: 1px solid var(--bs-border-color);
}

.pm-sidebar-right {
    border-right: none;
    border-left: 1px solid var(--bs-border-color);
}

.pm-sidebar .nav-link {
    color: var(--bs-body-color);
    padding: 0.5rem 1rem;
    white-space: nowrap;
}

.pm-sidebar .nav-link.active {
    background-color: var(--bs-primary);
    color: #fff;
    border-radius: var(--bs-border-radius);
}

.pm-sidebar .nav-link i {
    width: 1.5rem;
    text-align: center;
}

/* ── Fixed sidebar ────────────────────────── */
.pm-sidebar-fixed > div {
    background-color: var(--bs-dark-bg-subtle);
    border-right: 1px solid var(--bs-border-color);
    z-index: var(--pm-z-sidebar);
}

/* ── Partially collapsing sidebar ─────────── */
.pm-sidebar-partial {
    width: var(--pm-sidebar-width);
    transition: width var(--pm-transition-speed) ease;
    background-color: var(--bs-dark-bg-subtle);
    border-right: 1px solid var(--bs-border-color);
    z-index: var(--pm-z-sidebar);
}

@media (max-width: 991.98px) {
    .pm-sidebar-partial {
        width: var(--pm-sidebar-mini-width);
    }
    .pm-sidebar-partial .pm-sidebar-label {
        opacity: 0;
        width: 0;
        overflow: hidden;
        transition: opacity 0.2s ease;
    }
    .pm-sidebar-partial:hover,
    .pm-sidebar-partial:focus-within {
        width: var(--pm-sidebar-width);
    }
    .pm-sidebar-partial:hover .pm-sidebar-label,
    .pm-sidebar-partial:focus-within .pm-sidebar-label {
        opacity: 1;
        width: auto;
    }
}

/* ── Mini icon sidebar ────────────────────── */
.pm-sidebar-mini {
    width: var(--pm-sidebar-mini-width);
    transition: width var(--pm-transition-speed) ease;
    background-color: var(--bs-dark-bg-subtle);
    border-right: 1px solid var(--bs-border-color);
    z-index: var(--pm-z-sidebar);
}

.pm-sidebar-mini .pm-sidebar-label {
    display: none;
}

@media (min-width: 992px) {
    .pm-sidebar-mini {
        width: var(--pm-sidebar-width);
    }
    .pm-sidebar-mini .pm-sidebar-label {
        display: inline;
    }
}

/* Expand on hover at any size */
.pm-sidebar-mini:hover,
.pm-sidebar-mini:focus-within {
    width: var(--pm-sidebar-width);
}
.pm-sidebar-mini:hover .pm-sidebar-label,
.pm-sidebar-mini:focus-within .pm-sidebar-label {
    display: inline;
}

/* ── Fixed sidebar mobile collapse ────────── */
@media (max-width: 991.98px) {
    .pm-sidebar-fixed > div {
        width: var(--pm-sidebar-mini-width) !important;
    }
    .pm-sidebar-fixed .pm-sidebar-label {
        display: none;
    }
    .pm-main[style*="margin-left"] {
        margin-left: var(--pm-sidebar-mini-width) !important;
    }
}

/* ── Hero section ─────────────────────────── */
.pm-hero-section {
    border-radius: 0;
}

/* ── Breadcrumb bar ───────────────────────── */
.pm-breadcrumb-bar {
    padding: 0.5rem 0;
}

/* ── Sticky header offset ──────────────────── */
body.has-sticky-header .pm-container {
    padding-top: 4.5rem;
}
```

### 10.2 Wiring with Twig

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use PageMaker\PageMaker;
use PageMaker\Enums\{LayoutPattern, Breakpoint};
use PageMaker\Components\{Navbar, Sidebar, Footer, Breadcrumb, HeroSection};
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

// 1. Set up Twig
$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig   = new Environment($loader, ['cache' => __DIR__ . '/cache']);

// 2. Create renderer closure
$renderer = fn(string $template, array $context): string
    => $twig->render($template, $context);

// 3. Build the page
$page = new PageMaker($renderer);

$page->assets()
    ->addBootstrap()
    ->addBootstrapIcons()
    ->addCss('/css/pagemaker.css');

$page
    ->setTitle('Dashboard — My App')
    ->setLayout(LayoutPattern::OFFCANVAS_LEFT, Breakpoint::LG)
    ->setColumnWidths(3, 9, 0)
    ->setHeader(new Navbar(
        brandName: 'My App',
        items: ['Home' => '/', 'About' => '/about', 'Contact' => '/contact'],
    ))
    ->setLeftSidebar(new Sidebar(
        navItems: [
            ['icon' => 'house-door', 'label' => 'Home',      'href' => '/',          'active' => true],
            ['icon' => 'speedometer2','label' => 'Dashboard', 'href' => '/dashboard'],
            ['icon' => 'table',       'label' => 'Orders',    'href' => '/orders'],
            ['icon' => 'grid',        'label' => 'Products',  'href' => '/products'],
            ['icon' => 'people',      'label' => 'Customers', 'href' => '/customers'],
        ],
        heading: 'Navigation',
    ))
    ->setBreadcrumb(new Breadcrumb([
        'Home' => '/',
        'Dashboard' => null,
    ]))
    ->setMainContent(fn() => '<h1>Welcome to the Dashboard</h1><p>Your main content here.</p>')
    ->setFooter(new Footer(
        columns: [
            'Product'  => ['Features' => '/features', 'Pricing' => '/pricing'],
            'Company'  => ['About' => '/about', 'Blog' => '/blog'],
            'Support'  => ['Docs' => '/docs', 'Contact' => '/contact'],
        ],
        copyright: '© 2026 My App. All rights reserved.',
        socialLinks: ['twitter' => '#', 'github' => '#', 'linkedin' => '#'],
    ));

// 4. Output
echo $page->render();
```

## 10. Usage Examples

### 10.1 Pattern Selection Quick Reference

| Use Case | Recommended Pattern | Breakpoint | Column Widths |
|---|---|---|---|
| Marketing site / blog | `HOLY_GRAIL` | `LG` | `[0, 9, 3]` or `[3, 6, 3]` |
| Admin dashboard | `OFFCANVAS_LEFT` | `LG` | `[3, 9, 0]` |
| Documentation site | `STACKED` | `MD` | `[3, 6, 3]` |
| Email client / CRM | `FIXED_SIDEBAR` | `LG` | N/A (CSS-driven) |
| Analytics dashboard | `PARTIALLY_COLLAPSING` | `LG` | N/A (CSS-driven) |
| Mobile-first app | `OVERLAY_DRAWER` | `LG` | `[3, 9, 0]` |
| IDE / tooling UI | `MINI_ICON_SIDEBAR` | `XL` | N/A (CSS-driven) |
| Content CMS with deep nav | `ACCORDION_SIDEBAR` | `MD` | `[3, 9, 0]` |
| Right-panel detail view | `OFFCANVAS_RIGHT` | `LG` | `[0, 8, 4]` |

### 10.2 Composing Widgets Inside Slots

```php
$page->setMainContent(function () use ($twig) {
    $tabs = new TabSet(
        tabs: [
            'Overview'  => '<p>Product overview content...</p>',
            'Specs'     => '<table class="table">...</table>',
            'Reviews'   => '<div class="review-list">...</div>',
        ],
        style: 'pills',
    );

    $modal = new Modal(
        title: 'Confirm Order',
        body: '<p>Are you sure you want to place this order?</p>',
        footerHtml: '<button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                     <button class="btn btn-primary">Confirm</button>',
    );

    return $tabs->render()
         . $modal->triggerButton('Place Order', 'btn btn-success mt-3')
         . $modal->render();
});
```

### 10.3 Switching Layouts at Runtime

Because layout is a simple enum, you can select it dynamically:

```php
$patternName = $request->query('layout', 'holy_grail');
$pattern = LayoutPattern::from($patternName);

$page->setLayout($pattern, Breakpoint::LG);
```

---

## Appendix A: Accessibility Checklist

All generated markup follows these ARIA and semantic rules:

- `<header role="banner">` for site header
- `<main role="main" id="main-content">` for the primary content area
- `<aside role="complementary" aria-label="...">` for every sidebar
- `<nav aria-label="...">` for every navigation block (navbar, breadcrumb, sidebar nav)
- Offcanvas/modal elements include `aria-labelledby`, `aria-controls`, and `aria-expanded`
- Tab panels include `role="tablist"`, `role="tab"`, `role="tabpanel"`, and `aria-selected`
- Skip-to-content link: add `<a href="#main-content" class="visually-hidden-focusable">Skip to main content</a>` as the first child of `<body>` in `base.html.twig`

## Appendix B: CSS Custom Properties Reference

| Property | Default | Used By |
|---|---|---|
| `--pm-sidebar-width` | `280px` | All sidebar patterns |
| `--pm-sidebar-mini-width` | `64px` | FIXED_SIDEBAR, PARTIALLY_COLLAPSING, MINI_ICON |
| `--pm-transition-speed` | `0.25s` | Sidebar expand/collapse animations |
| `--pm-z-sidebar` | `1030` | Fixed/sticky sidebars |
| `--pm-z-header` | `1040` | Sticky navbar |

Override these at the `:root` level or on individual elements to customize dimensions without editing the source CSS.
