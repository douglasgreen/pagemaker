# pagemaker
PHP microframework 

## Design goals
* All code, no GUI builders.
* All functions without $this are static.
* All timed JS functions must be added to a queue.
* Avoid internal and inline JS and CSS because hard to replace.
* Class attributes all protected, functions all public or protected, static functions all public.
* CMS where pages are stored in PHTML templates in version control.
* Code is simple enough to read.
* Dependency injection.
* File location in hierarchy by generality (higher is more general).
* Identifiers all camel case.
* Lightweight and efficient.
* Minimal coupling. Pass scalars not classes as arguments.
* No dependencies.
* No session abuse (objects shouldn't be stored in sessions).
* No writable static properties.
* Organized JS and CSS by class or ID.
* Prefab components.
* Separate layout and color themes.
* Support UUID, versioning, and uploads in database.
* Type hints everywhere.
* Ugly URLs for routing. Named parameters are better.
* Work on CLI, JSON, or HTML.

## Key concepts
* This is a micro-CMS more than a microframework, since you're given prebuilt page elements.
* The page CSS, JS and HTML are all laid out in predefined IDs allowing a modular approach to page building.
* Each page ID is a container that is modular and extensible, allowing adding more sections with their own IDs.
* The router is simple, doesn't require server config, and maps directly to the class structure.
* The plugins provide for extensible units combining PHP, HTML, JS, and CSS, and a templater like Twig or PHPTAL where errors are isolated to each plugin.
* The system is vaguely analogous to the WordPress system of plugins and page building but in simplified new code.

## Philosophy
A well-design system is easy to describe and understand. By using a modular approach with common vocabulary for
top-level page elements, it's possible to understand a web app design. And as you move from project to project, each
project is laid out in the same way, helping you to quickly understand its design.

The plugin system is also a robust system where errors in a widget inside the page don't break the page.

Other PHP frameworks focus on:
* Routing with pretty URLs. But pretty URLs aren't as clear as key/value pairs. Routing is also redundant to the web
  server, which does routing already.
* Templating, which is redundant to PHP's built-in templating and forces you to learn another language for templating.

Their main features are redundant and they don't provide predefined page-building structure or a robust plugin
architecture. So why bother to install them?

## Page layout
The body is a series of rows.

```
<body id="pmBody">
    <header id="pmHeader">
        <section class="headerSection" id="banner">
            <div id="logo"></div>
            <div id="searchBar"></div>
            <div id="iconBar"></div>
        </section>
        <section class="headerSection" id="menuBar"></section>
        <section class="headerSection" id="errorBar"><!-- This section available to print errors in red. --></section>
    </header>
    <nav id="pmLeftNav">
        <section class="leftNavSection"></section>
        <section class="leftNavSection"></section>
        ...
    </nav>
    <main id="pmMain">
        <section class="mainSection"></section>
        <section class="mainSection"></section>
        ...
    </main>
    <nav id="pmRightNav">
        <section class="rightNavSection"></section>
        <section class="rightNavSection"></section>
        ...
    </nav>
    <footer id="pmFooter">
        <section class="footerSection"></section>
        <section class="footerSection"></section>
        ...
    </footer>
</body>
```

## Layered and modular design
The page has a layered design:
* The top level is the header/nav/main/footer tags identified by IDs and styled in a grid.
* The medium level is a set of sections, identified by classes, which are built as widgets including a separate unit JS/CSS/HTML.
* The bottom level is whatever is in a widget, such as div or p contents.

The page also has a modular design, because each widget and its errors are self-contained.

## Widget
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
* JS has an event queue for structure.

```
public/styles/pm_normalize.css
public/scripts/pm_functions.js

public/styles/pm_page_styles.css
public/scripts/pm_page_events.js

public/styles/pm_body_styles.css
public/scripts/pm_body_events.js

public/styles/pm_header_styles.css
public/scripts/pm_header_events.js

public/styles/pm_banner_styles.css
public/scripts/pm_banner_events.js

public/styles/pm_logo_styles.css
public/scripts/pm_logo_events.js

public/styles/pm_searchbar_styles.css
public/scripts/pm_searchbar_events.js

public/styles/pm_iconbar_styles.css
public/scripts/pm_iconbar_events.js

public/styles/pm_menu_styles.css
public/scripts/pm_menu_events.js

public/styles/pm_leftnav_styles.css
public/scripts/pm_leftnav_events.js

public/styles/pm_main_styles.css
public/scripts/pm_main_events.js

public/styles/pm_section_styles.css
public/scripts/pm_section_events.js

public/styles/pm_rightnav_styles.css
public/scripts/pm_rightnav_events.js

public/styles/pm_footer_styles.css
public/scripts/pm_footer_events.js

public/styles/pm_colors_light.css
public/styles/pm_colors_dark.css
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
public/styles/[css]
public/scripts/[js]
public/[packageX]/styles/[css]
public/[packageX]/scripts/[js]
public/[packageY]/styles/[css]
public/[packageY]/scripts/[js]
public/[packageZ]/styles/[css]
public/[packageZ]/scripts/[js]
public/[packageZ]/[subpackage]/styles/[css]
public/[packageZ]/[subpackage]/scripts/[js]
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
│   ├── scripts/
│   ├── styles/
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

## Todo
Rewrite header into generic sections.
Finish plugins.
Write a logger like Monolog that logs exceptions to daily rotated file.
https://www.loggly.com/ultimate-guide/php-logging-basics/
* Does output support text, HTML, and JSON?
* Add debug mode with detailed exceptions.
* Add error logging to JS.
* Remove jQuery as dependency.
* How to bundle assets with widgets like images?
* Use transactions.
* How to handle z-index problems?
* How to handle JS queing conflicts?
* Add back link outline on focus and underline on hover.
