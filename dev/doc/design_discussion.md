# Design discussion

Our current system of organizing CSS and JS lacks any higher-level structure or rules. However, a well-designed system should be easy to describe and easy to understand. It is also easy to reapply without reinventing the wheel. So here is my attempt to describe a page builder system.

An HTML page consists of:

* A fixed set of header tags, like title or meta
* A limited set of semantic body tags, like header, footer, and nav, that are arranged in a few basic template forms and need to be made responsive at various breakpoints (layout) and add a basic theme (color).
* An open-ended set of body tags, that can be separated into independent widgets, like menu or side nav. These should represent independent units of CSS and JS that don't add style or events to anything else on the page.
* Third-party components like HTML/CSS exported from Figma or JS templates used by Vue.

A page builder should represent these basic facts. It should allow the widgets to be built as separate components and catch their errors to make the page more robust. The basic plan is:
* Use IDs for the top-level semantic tags like pmHeader and pmFooter, and represent the layout with one stylesheet and the theme with another stylesheet so they can be freely separated.
* Build each top level in terms of sections with class names, and separate their layouts and styles into files with the class name.
* Organize the third-party components according to their own rules. Having a well-defined system for the rest of the CSS and JS ensures that these other components will not be interfered with. It also allows the development of portable components that can be copied from project to project as long as they use the same page builder.

The key questions that you want to answer with this system are:

* What style selector should I use? If it is a page style, use page.css and style the responsive layout according to the IDs at each breakpoint. Then place the colors in their own theme directory.
* What file should I put them in? page.css or [widget].css, and js. For themes, the [color].css. If color separation is not necessary, they can be included in the [widget].css.
* How can I tell if the file conforms to the system? All of its top-level selectors should be the same ID or class as the file name.
* What directory should I put the files in? In the top-level directory of their most general use.
* How should I build a widget? Just provide it with generic data and let it do all of the work so that it's errors can be caught.

The current system or CSS/JS organization answers none of these questions persuasively therefore this system is better.

## More notes

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

## Goals

* Absolute is better than relative.
* All code, no GUI builders.
* All functions without $this are static.
* All timed JS functions must be added to a queue.
* Class attributes all protected, functions all public or protected, static functions all public.
* CMS where pages are stored in PHTML templates in version control.
* Code is simple enough to read.
* Dependency injection.
* Explicit is better than implicit.
* File location in hierarchy by generality (higher is more general).
* Identifiers all camel case.
* Lightweight and efficient.
* Manual is better than magic.
* Minimal coupling. Pass scalars not classes as arguments.
* No dependencies.
* No session abuse (objects shouldn't be stored in sessions).
* No writable static properties.
* Organized is better than unorganized.
* Separate layout and color themes.
* Simple is better than complex.
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

## Development process

* Minimalism - Including minimal dependencies makes upgrades easier. Of course there is good and bad in everything. That requires you to re-implement some basic feature which might then have security flaws. So you must make an intelligent build versus install decision. Implementing basic features like an email class in PageMaker is only intended to cover simple cases. Any more complex cases should install a full feature dependency. But the lack of dependencies in PageMaker let you choose freely between those dependencies.
* Incrementalism - Development should proceed in an incremental fashion. First, a working kernel of the system should be developed that enables basic data storage. Then it should be overlaid with the minimum viable product (MVP). Once you have a working system, your development should add small changes and features while always keeping the system in a working state.

## Things to avoid

* Don't use base rules that style individual tags like ul. Tags are always reused for different purposes and your base rules will inevitably lead to conflict.
* Don't get into specificity fights. In a well-designed system, you shouldn't have to overwrite other styles.
* Don't use the !important tag because it's the worst kind of specificity fight.

## Code readability

Pagemaker is a simple developer-oriented framework. There are of course more complete front-end tools and more complex frameworks available. It's key value proposition is that:
* The page layout process is well defined, layered, and modular more than any other competing organization system
* The code is simple enough to read, compatible with other development frameworks, and flexible to override or use components independently.

In addition, it would be a simple matter to re-implement the page organizational concepts in any other framework, so feel free to do so.

## Content-dependent

Much developer advice is bad because it is not justified and context-dependent. For example, https://en.wikipedia.org/wiki/SOLID:

The Single-responsibility principle: "There should never be more than one reason for a class to change." In other words, every class should have only one responsibility.
The Open–closed principle: "Software entities ... should be open for extension, but closed for modification."
The Liskov substitution principle: "Functions that use pointers or references to base classes must be able to use objects of derived classes without knowing it." See also design by contract.
The Interface segregation principle: "Clients should not be forced to depend upon interfaces that they do not use."
The Dependency inversion principle: "Depend upon abstractions, [not] concretions."

The problems with these pithy bits of advice as given are:
* The principles aren't justified by telling you why you should do each one and what happens if you don't. That means you are not likely to implement them correctly.
* The principles are not grounded in a particular context that tells you when you need to do them and when you don't need to do them. That means you're likely to apply them excessively in the wrong context.

Programming rules are not absolutes but are particular adaptations and you should know when and how to apply them.

Criticisms:
* SRP: Having one reason to change is vague and unexplained. It really means that each class should be a conceptual whole because it's easier to understand. It should also manage only one resource or operate on only one layer of your design, such as separating the processing from the input and output so that you can test processing without having to do input and output.
* OCP: This principle predates version control and is probably obsolete. Nothing is wrong with modifying classes in a proper system of change and versioning. However, remember that it is easier to extend and modify because modification requires changing existing code that depends on a class.
* LSP: Breaking this principle would make polymorphism fail because the substitute class would not work as expected.
* ISP: This is more of a front-end design principle because front-end designers of user interfaces need to remember that different users have different purposes. This is not even really a developer principle because developer interfaces are always small single purpose designs anyway.
* DIP: This principle doesn't tell you why but the reason is to swap out different implementations of the concrete. If you don't need to swap out different implementations, you can ignore this principle.

## Lopsided development

Our development process is badly lopsided. Back in the old days, PHP, CSS, and JS would all be dumped in a big pile and be unorganized.

PHP then developed methods of organization like namespaces and auto loading. Instead of using these methods to build large-scale projects, everything split into REST APIs. These are organized on the back end with numerous interfaces as though they were going to be general large scale projects. Instead they are small scale projects that are filtered through REST APIs so they're internal API flexibility is wasted. These are over organized.

Our JS and CSS went through no such organizational period so they're still a giant blob of whatever.

This is overall poor architecture and should be remedied with a rebalancing. There needs to be more organization on the JS and CSS side. And PHP organization needs to be proportional to the actual accessibility of the project. If it's hidden behind the REST API, there's no need to pretend that it's going to be some giant project that needs to be littered with interfaces everywhere. Only libraries or large projects need that. Passing the output through a REST API cuts off the extensibility because the program interface is closed and only the REST API is exposed.

## Features
Website features are decomposed in a hierarchy under top-level version:

v1/feat1/feat2/feat3...

Each feature directory consists of:
* An index.php for routing.
* A widgets/ directory for widgets.
* api/ for REST API endpoints
* images/ directory for images
* js/ directory for JavaScript
* css/ directory for stylesheets
* templates/ directory for templates

Template files like *.phtml and *.twig can be hidden from the public with web server rules.

The assets in each directory should pertain to that feature and any lower-level features but not higher-level features.

## Standards

The way standards should be defined is:
* Each standard should specify what you should do or what you must do.
* Formatting standards should be automated.
* Standard should specify larger design rules that make a system easy to describe and easy to understand and modify.
* Standards should rarely change in a way that breaks backward compatibility. If they do, they should provide an automated upgrade path.

The way standards often work is focusing on trivialities like naming conventions that aren't even automated. This increases the cognitive burden on the programmer while ignoring larger issues of design.

