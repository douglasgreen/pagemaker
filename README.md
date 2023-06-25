# pagemaker
PHP microframework 

## Design goals
* All functions without $this are static.
* Code is simple enough to read.
* Container.
* Dependency injection.
* File location in hierarchy by generality (higher is more general).
* Lightweight and efficient.
* Minimal coupling. Pass scalars not classes as arguments.
* No dependencies.
* No session abuse (objects shouldn't be stored in sessions).
* No writable static properties.
* Organized JS and CSS by class or ID.
* Prefab components.
* Support UUID, versioning, and uploads in database.
* Type hints everywhere.
* Ugly URLs for routing. Named parameters are better.
* Work on CLI, JSON, or HTML.

## Page layout
The body is a series of rows.

<body id="body">
    <header id="header">
        <div id="banner">
            <div id="logo"></div>
            <div id="searchBar"></div>
            <div id="iconBar"></div>
        </div>
        <nav id="menu"></nav>
    </header>
    <nav id="leftNav">
        <section class="leftNavSection"></section>
        <section class="leftNavSection"></section>
        ...
    </nav>
    <main id="main">
        <section class="mainSection"></section>
        <section class="mainSection"></section>
        ...
    </main>
    <nav id="rightNav">
        <section class="rightNavSection"></section>
        <section class="rightNavSection"></section>
        ...
    </nav>
    <footer id="footer">
        <section class="footerSection"></section>
        <section class="footerSection"></section>
        ...
    </footer>
</body>

## Components
Each component has a builder class to make a generic version.

## CSS
Only three queries:
* Small: < 600px
* Medium: 600px - 1200px
* Large: > 1200px

## Router
* Each namespace has its own front controller index.php.
* Pass a parameter `route=name_action` like `route=customer_view`.
* A class in that namespace will call the method CustomerController::getView() or CustomerController::postView().

## Assets
* JavaScript and CSS assets are laid out by page element.
* Element layouts go into the layout directory.
* All colors go into the themes directory.
* All functions go into `pm_functions.js`.
* Each CSS or JS in each element file starts with a top-level ID or class selector to prevent conflicts.

```
assets/layout/pm_normalize.css
assets/layout/pm_functions.js

assets/layout/pm_page_styles.css
assets/layout/pm_page_events.js

assets/layout/pm_body_styles.css
assets/layout/pm_body_events.js

assets/layout/pm_header_styles.css
assets/layout/pm_header_events.js

assets/layout/pm_banner_styles.css
assets/layout/pm_banner_events.js

assets/layout/pm_logo_styles.css
assets/layout/pm_logo_events.js

assets/layout/pm_searchbar_styles.css
assets/layout/pm_searchbar_events.js

assets/layout/pm_iconbar_styles.css
assets/layout/pm_iconbar_events.js

assets/layout/pm_menu_styles.css
assets/layout/pm_menu_events.js

assets/layout/pm_leftnav_styles.css
assets/layout/pm_leftnav_events.js

assets/layout/pm_main_styles.css
assets/layout/pm_main_events.js

assets/layout/pm_section_styles.css
assets/layout/pm_section_events.js

assets/layout/pm_rightnav_styles.css
assets/layout/pm_rightnav_events.js

assets/layout/pm_footer_styles.css
assets/layout/pm_footer_events.js

assets/themes/pm_light_colors.css
assets/themes/pm_dark_colors.css
```

## Package structure
If a project is divided into packages, recreate the top-level directory structure in each package directory:

```
[package]/src
[package]/assets
```
