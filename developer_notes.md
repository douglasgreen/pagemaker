# Developer notes
## Design goals
* All code, no GUI builders.
* All functions without $this are static.
* All timed JS functions must be added to a queue.
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
A well-design system is easy to describe, understand, and modify. By using a modular approach with common vocabulary for
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

## CSS
Only three queries:
* Small: < 600px
* Medium: 600px - 1200px
* Large: > 1200px

## Router
* Each namespace has its own front controller index.php.
* Pass a parameter `route=name_action` like `route=customer_view`.
* A class in that namespace will call the method CustomerController::getView() or CustomerController::postView().

## JavaScript
JavaScript is widely used as a component and page builder nowadays. I don't like it though and I don't like the JavaScript ecosystem.
* JavaScript is architecturally poor because it starts on the output layer with accidental details about how the document is presented.
* JavaScript runs in the browser which leads to poor error reporting and browser incompatibilities.
* JavaScript always drags in a giant pile of dependencies to maintain.
* Typical JavaScript is lacking in the features of well-designed modularity and typing that enable scalable, well-organized programming.
* The JavaScript language itself was hastily designed and polished by committee. It's endless feature enhancements make it more complex without making it more attractive. It's the only language I know that has a book that describes the good parts and all of the bad parts that you should avoid.

My basic concept of JavaScript is that it should be used to update the page but not to render the page. Thus I use it only where local page updates are required. The initial page load should always be pure PHP. This also implies that I avoid depending on REST APIs for basic page rendering so that page loads are monolithic and fast.

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
* Make comparisons with the other CSS systems in https://css-tricks.com/methods-organize-css/

## Parallel hierarchies
Consider merging file directories that are parallel hierarchies, unless one is public and the other private.

So related interfaces, classes, and implementations like Widgets should go into the same directory.

## One public directory
There is usually a single public directory and multiple private directories in a repository. The reason is that the public directory is often treated especially by being the root of a document server or a distributable folder like `dist`. And so the private directory is can be split into multiple directories for efficiency. Because they are not the public directory, they are all by default private.

## Development process
* Minimalism - Including minimal dependencies makes upgrades easier. Of course there is good and bad in everything. That requires you to re-implement some basic feature which might then have security flaws. So you must make an intelligent build versus install decision. Implementing basic features like an email class in PageMaker is only intended to cover simple cases. Any more complex cases should install a full feature dependency. But the lack of dependencies in PageMaker let you choose freely between those dependencies.
* Incrementalism - Development should proceed in an incremental fashion. First, a working kernel of the system should be developed that enables basic data storage. Then it should be overlaid with the minimum viable product (MVP). Once you have a working system, your development should add small changes and features while always keeping the system in a working state.

## Things to avoid
* Don't use base rules that style individual tags like ul. Tags are always reused for different purposes and your base rules will inevitably lead to conflict.
* Don't get into specificity fights. In a well-designed system, you shouldn't have to overwrite other styles.
* Don't use the !important tag because it's the worst kind of specificity fight.

## Internal APIs
API endpoints can be a subdirectory of the current project and don't have to be a separate project. They can reuse the current database connection and HTTP host.

## File copying
I need to invent an actual plug-in mechanism to copy widgets between projects. And I need to be able to version them as well.

I'm thinking of a directory into which all of the CSS, JS, Twig, PHTML, font, and asset files can go. Then a manifest file to describe it all.

## Object-oriented programming
A well-behaved class:
* Has no mutable static attributes.
* Uses protected or public for all members so they can be overridden.
* Breaks functions into pieces so they can be ovverridden.
* Balances specific type-checking of inputs with flexible inputs.
* Is easy to set up.
* Isn't stored in the session.

## Interfaces vs. abstact classes
Interfaces let the user define their own data as well as their own functionality. So interfaces are more extensible
than abstract classes.

Interfaces should not define constructors because those also define implementation specific data details.

Abstract classes are used instead of concrete classes when the implementation is by definition general and incomplete. When a complete definition can be given, it is preferred to use a concrete class directly.

An example of an abstract class is the Widget class, because it sets up a widget typical data without defining any behavior.

An example of concrete class is the email sender class, because it's always possible to send email due to Its predefined behavior.

Optional values of function arguments are left out of the interface definitions.

## Class names
Don't add noise words like Manager or Handler at the end of class names. All classes manage and handle data. It's part of the definition of class.

PSR rules are used for class names:
* AbstractX
* XInterface

## Single responsibility principle
Don't mix I/O, processing, and storage in the same class?

## File order
The members come in this order:
* properties
* methods

The top groups come in this order:
* const
* static
* instance

The access levels come in this order:
* public
* protected

The members come in this order:
* logical reference
* alphabetical

For example, the methods come in this logical order:
* magic methods/constructor/destructor
* setters
* getters
* finalizers like render, save, etc.

Getters and setters should be symmetrical by default, that is, each getter should have a setter and vice versa.

## Namespaces
All namespaces should be singular.

Prefer abstract names for namespaces: e.g. the Validator class in the Validation namespace and Routing\Router.

A namespace can also be named after the thing being managed, e.g. File or Database.

So a namespace should fill in the blank "I am doing _____ or managing a/an _____".

## Controllers
A PHP controller class, especially in the context of the Model-View-Controller (MVC) design pattern, typically contains the following functions:

* __construct(): This is the constructor function that is automatically called when an object of the class is created. It is often used to initialize class properties or perform any setup that the class needs before it is used.
* index(): This function is usually the default method that is called when no method is specified. For example, in a blog application, the index method of the PostsController might retrieve all the blog posts and pass them to a view to be displayed.
* create(): This function is typically used to display a form to create a new resource (like a new blog post).
* store(): This function is usually responsible for handling the POST request from the create form, validating the input, and storing the new resource in the database.
* show($id): This function is typically used to display a single resource. The $id parameter is used to find the specific resource in the database.
* edit($id): This function is usually used to display a form for editing an existing resource.
* update($id): This function is typically responsible for handling the POST request from the edit form, validating the input, and updating the resource in the database.
* destroy($id): This function is usually used to delete a specific resource from the database.

Remember that these are just typical functions and the actual functions in a PHP controller class can vary depending on the specific needs of the application. Also, the names of these functions can change based on the conventions of the PHP framework being used. For example, in Laravel, these are the standard resource controller methods.

## References
* https://www.elinext.com/blog/modular-web-design/
* https://www.designrush.com/agency/website-design-development/trends/modular-web-design
* https://www.wearediagram.com/blog/modular-web-design-designing-with-components
* https://beamtic.com/creating-a-router-in-php
