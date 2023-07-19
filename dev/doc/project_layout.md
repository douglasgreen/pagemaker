## Project layout

A well-organized directory structure is essential for PHP projects to maintain a clean and scalable codebase. While there isn't a one-size-fits-all solution, here is a commonly used directory structure that works well for many PHP projects.

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

This is just a starting point, and depending on the complexity of your project or any specific requirements, you may need to adjust or expand this structure. Remember, the goal is to maintain a clear separation of concerns, keep your code organized, and make it easy to navigate and maintain your PHP project.

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

## Parallel hierarchies

Consider merging file directories that are parallel hierarchies, unless one is public and the other private.

So related interfaces, classes, and implementations like Widgets should go into the same directory.

## One public directory

There is usually a single public directory and multiple private directories in a repository. The reason is that the public directory is often treated especially by being the root of a document server or a distributable folder like `dist`. And so the private directory is can be split into multiple directories for efficiency. Because they are not the public directory, they are all by default private.

## File copying

I need to invent an actual plug-in mechanism to copy widgets between projects. And I need to be able to version them as well.

I'm thinking of a directory into which all of the CSS, JS, Twig, PHTML, font, and asset files can go. Then a manifest file to describe it all.

