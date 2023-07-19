# Introducing PageMaker

An innovative PHP microframework. The status is **currently under development and not ready for production use**.

The purpose of PageMaker is to organize front-end development of web pages and files so that independent widgets can be copied from project to project and from page to page within a project. This exceeds the typically disorganized web project and even the usual CSS organization methods.

## Overview

Web applications are fundamentally collections of web pages. A well-structured web page is a product of a philosophical and logical design approach. This includes:
* Hierarchical design: Top-level page containers, intermediate-level widgets, and small-scale widget features.
* Modular architecture: Divide the application into independent widgets, each encapsulating its own CSS, JS, and HTML templates.
* Information hiding: The style of top-level CSS and JS selectors hides information about their internal organization and presents a smaller interface.
* Plug-in architecture: Widgets operate independently, allowing their errors to be identified and handled separately.
* Unambiguous file organization: Each widget is represented by its distinct set of CSS, JS, and HTML template files.

## Building Pages with PageMaker

### Top-Level Containers
The PageMaker microframework facilitates the construction of a web page's top-level structure via the Page class, which generates standard containers:
* `<body class="pmBody">`: Used for global body styles like background color or font face.
* `<header class="pmHeader">`: Potential housing for logo, search bar, icon links, and menu navbar.
* `<main class="pmMain">`: The primary content of the page.
* `<footer class="pmFooter">`: Likely contains link columns and copyright information.

These containers are identified through unique classes: `pmBody`, `pmHeader`, `pmMain`, and `pmFooter`. Unique class names are used instead of the HTML tag names to show that styles are only being applied on request in a specific system.

The containers should be organized using a grid layout. Either header or footer or can be omitted. Because only the three top-level containers are provided in the body, they can always be styled in a sequence where each one occupies 100% width. This prevents you from having to make decisions about how to lay out sidebars at the top level.

Class names are used instead of ID names to make it possible to override general page styles inside more specific widgets.

Top-level code should be limited to addressing concerns that are truly global, meaning that there should be infrequent need to override such choices. This code should go into files like:
* `pmPage.css`
* `pmPage.js`
* `pmPage.phtml` or `pmPage.twig`

PHTML is the name we give to templates using plain PHP and HTML only and Twig is the popular template library.

Code in these CSS and JS is considered well-constructed when it only contains top-level styles targeting these container classes. Reasonable exceptions can be made for code that needs to target the document, for example to receive key presses.

Each top-level container should further specify a grid layout for the widgets in the container. A grid layout is better than asking the widgets to place themselves using float. Those layouts should go into section files, such as `pmBody.css`. The top-level selectors in these files should reflect the container, such as `.pmBody`. The layout can either provide:
* A generic layout such as `.pmBody section` that provides space between a series of generic section tags.
* A specific layout for navbars such as `.pmBody .pmLeftNav` that can float to the left, right, or above depending on responsive design and other specific page widgets.

The top-level files should be collected into subdirectories of a `layouts` directory. Each subdirectory should be given the name of the basic page layout, such as `layouts\base` or `layouts\leftnav`. If color themes are required, they can be split into subfiles like `pmPageLight.css` and `pmPageDark.css` for separate application.

### Intermediate-Level Widgets

PageMaker's middle layer comprises various widgets that extend the Widget class. These widgets are rendered using semantic HTML tags like `<section class="pmMenuWidget">` tags, with 'pmMenuWidget' being the name of a possible menu widget. Widgets should be given short, meaningful names that are unique within their program context. The names should end in Widget to make them easily identifiable as widget names.

There are a limited number of semantic tags that can function as widgets, including:
* `<article>`: Denotes a self-contained composition like a blog post, forum post, or a news story.
* `<aside>`: Marks content related to the main content but can be separately considered, such as a sidebar or pull-quote.
* `<nav>`: Defines a section of navigation links that either lead to different parts of the document or other documents.
* `<section>`: Signifies a standalone section of a document, typically containing related content with a common theme.

We treat each widget as a plug-in; its rendering errors are caught and displayed within the widget's tag. This approach makes the page modular and resilient.

Every widget houses its own JS, CSS, and HTML template files, such as Twig or PHTML. They are organized in distinct files named after each widget:
* `pmMenuWidget.js`
* `pmMenuWidget.css`
* `pmMenuWidget.phtml` or `pmMenuWidget.twig`

A well-organized JS and CSS file's top-level selector is `.pmMenuWidget`, mirroring the widget class name applied to its `<section class="pmMenuWidget">` tag.

The widget files should be collected into subdirectories of a `widgets` directory. Each subdirectory should be given the name of the widget, such as `widgets\menuWidget`. If color themes are required, they can be split into subfiles like `pmMenuWidgetLight.css` and `pmMenuWidgetDark.css` for separate application.

Our method encourages the development of widgets as separate and interchangeable parts to reduce conflicts. The modularity allows for the easy exchange, modification, and duplication of widgets in various projects, as long as they follow the same page structure. Additionally, since the widget is a thin wrapper, it can flexibly run different kinds of external code, such as rendering components from other sources.

### Low-Level Divs

Each widget is composed of one or more divs, encapsulated within its container and deployed using a flexbox layout. The widgets are arranged by page layout code as discussed above. But the task of rendering inside the widget is carried out by the widget itself since it is a matter of local concern.

Given their self-contained nature, widgets can exercise considerable flexibility in their design. For instance, the CSS within a widget can employ information hiding by utilizing tag selectors inside the top-level class selector.

* `.pmMenuWidget p` - This styles all 'p' tags within the widget, so you don't need a subclass designation.
* `.pmMenuWidget .mySubclass` - By using a subclass, you can expose it to the widget's CSS interface where it's implemented in the HTML.
* `.pmMenuWidget` using inline styles - This can be a viable approach when there's certainty that the CSS won't need to be reused within the widget.

### Package directories

In a complex project, you may need to repeat the same directory and file organization within packages and subpackages. These should be organized in a hierarchical directory like `[package]/[subpackage]/...`. Then at each level of the package hierarchy you would repeat the same structure of layouts and widgets.

### PHP autoloading

PHP files are usually organized into a top-level directory like `app` or `src` which enables PSR-compatible autoload. The PHP source code of widgets can be organized within the `Widget` namespace of such a directory. The widget should be maintained as separate files or subdirectories of related code in order to maintain the possibility of easily copying a widget from project to project.

### Other assets

Other assets like images and fonts can be put into an `assets` directory. Again you should maintain some kind of organized, hierarchical directory structure where assets for each widget are kept separate.

### Comparison with Typical Design

The conventional web design lacks:
* Layering: Absence of clear separation of various webpage features at different scales.
* Modularity: JS and CSS often intermingle, making individual features hard to isolate for replacement or redesign.
* Robustness: Errors within individual page components are typically not isolated, resulting in full-page errors.
* Information hiding: Every CSS selector and JS event is exposed at the global level.
* Clear organization: Guidelines for CSS, JS, and HTML code file organization are often missing.

The lack of clear design often leads to a disordered codebase, which is challenging to maintain and enhance.
