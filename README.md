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
If a project is divided into packages X, Y, and Z, recreate the top-level directory structure in each package directory:

```
app/[classes]
app/[packageX]/[classes]
app/[packageY]/[classes]
app/[packageZ]/[classes]
app/[packageZ]/[subpackage]/[classes]
...
assets/layout/[layouts]
assets/themes/[themes]
assets/[packageX]/layout/[layouts]
assets/[packageX]/themes/[themes]
assets/[packageY]/layout/[layouts]
assets/[packageY]/themes/[themes]
assets/[packageZ]/layout/[layouts]
assets/[packageZ]/themes/[themes]
assets/[packageZ]/[subpackage]/layout/[layouts]
assets/[packageZ]/[subpackage]/themes/[themes]
```

## Configuration
INI files are the chosen format.

## Rework
A well-organized directory structure is essential for PHP projects to maintain a clean and scalable codebase. While
there isn't a one-size-fits-all solution, here is a commonly used directory structure that works well for many PHP
projects.

```
project/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   ├── Helpers/
│   └── Config/
├── config/
│   ├── app/
│   ├── database/
│   └── mail/
├── public/
│   ├── css/
│   ├── js/
│   └── index.php
├── resources/
│   ├── views/
│   ├── assets/
│   └── lang/
├── storage/
│   ├── logs/
│   └── cache/
├── tests/
├── vendor/
├── .env
├── .gitignore
├── composer.json
├── composer.lock
└── README.md
```

Let's go through the main directories and their purposes:

- `app/`: This directory contains the core application files.
  - `Controllers/`: Contains PHP classes responsible for handling user requests and responses.
  - `Models/`: Contains PHP classes that represent the application's data structures and interact with the database.
  - `Views/`: Contains templates or view files for rendering the user interface.
  - `Helpers/`: Contains reusable helper functions or classes.
  - `Config/`: Contains configuration file loaders for the application.

- `config/`: This directory contains configuration files in INI format.
  - `app/`: Contains application configuration files.
  - `database/`: Contains database configuration files.
  - `mail/`: Contains email configuration files.

- `public/`: This directory is publicly accessible and serves as the document root for your web server.
  - `css/`: Contains CSS stylesheets.
  - `js/`: Contains JavaScript files.
  - `index.php`: The entry point of your application that handles all incoming requests.

- `resources/`: This directory holds non-public resources and assets.
  - `views/`: Contains additional view templates, partials, or layouts.
  - `assets/`: Contains non-PHP assets like images, fonts, etc.
  - `lang/`: Contains language files for internationalization or localization.

- `storage/`: This directory stores application-generated files.
  - `logs/`: Contains log files.
  - `cache/`: Contains cached files or data.

- `tests/`: Contains test files and directories for unit or integration testing.

- `vendor/`: Contains third-party dependencies managed by Composer.

- `.env`: Configuration file containing environment-specific settings.

- `.gitignore`: Specifies files and directories to be ignored by version control (Git).

- `composer.json` and `composer.lock`: Files used by Composer to manage PHP dependencies.

- `README.md`: A documentation file providing information about the project.

This is just a starting point, and depending on the complexity of your project or any specific requirements, you may
need to adjust or expand this structure. Remember, the goal is to maintain a clear separation of concerns, keep your
code organized, and make it easy to navigate and maintain your PHP project.
