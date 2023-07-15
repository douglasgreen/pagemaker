# Introducing PageMaker
A Revolutionary PHP Microframework

## Overview
Web applications are fundamentally a collection of web pages. A well-structured web page is a product of a thoughtful and logical design approach. This includes:
* Hierarchical design: Top-level page containers, intermediate-level widgets, and small-scale widget features.
* Modular architecture: Divide the application into independent widgets, each encapsulating its own CSS, JS, and HTML templates.
* Plug-in architecture: Widgets operate independently, allowing their errors to be identified and handled separately.
* Unambiguous file organization: Each widget is represented by its distinct set of CSS, JS, and HTML template files.

## Building Pages with PageMaker
### Top-Level Containers and Sections
The PageMaker microframework facilitates the construction of a web page's top-level structure via the Page class, which generates standard containers:
* `<header>`: Potential housing for logo, search bar, icon links, and menu navbar.
* `<main>`: The primary content of the page.
* `<footer>`: Likely contains link columns and copyright information.

These containers are identified through unique IDs: `pmHeader`, `pmMain`, `pmFooter`. They are organized using a grid layout and stylized with CSS in a `pmPage.css` file. 

Our emphasis on standard IDs is a testament to PageMaker's commitment to clear, project-specific organization. CSS and JS should target these IDs to avoid unwanted styling. Thus, a well-constructed `pmPage.css` file should only contain top-level styles targeting these container IDs.

Top-level containers can be further divided into sections, each denoted with their semantic HTML tag and identified with a class name:
* `<article>`
* `<aside>`
* `<nav>`
* `<section>`

### Intermediate-Level Widgets
PageMaker's middle layer comprises various widgets that extend the Widget class. These widgets are rendered as `<section class="myWidget">` tags, with 'myWidget' being the widget's name. 

We treat each widget as a plug-in; its rendering errors are caught and displayed within the widget's section. This approach makes the page modular and resilient.

Every widget houses its own JS, CSS, and HTML template files, such as Twig, PHPTAL, or basic PHP HTML (`.phtml`). They are organized in distinct files named after each widget:
* `myWidget.js`
* `myWidget.css`
* `myWidget.phtml` or `myWidget.twig`

A well-organized JS and CSS file's top-level selector is `.myWidget`, mirroring the widget class name applied to its `<section class="myWidget">` tag.

Our approach cultivates independent and modular widgets, minimizing conflicts. The modularity enables widget swapping, altering, and replicating across different projects, provided they adhere to the same page-building scheme. Furthermore, because the widget is a mere wrapper, it can execute any third-party code, including rendering third-party components.

### Low-Level Divs
Each widget comprises one or more divs rendered within its container using a flexbox. The widget itself performs the rendering because it pertains to local concerns.

### Comparison with Typical Design
The conventional web design lacks:
* Layering: Absence of clear separation of various webpage features at different scales.
* Modularity: JS and CSS often intermingle, making individual features hard to isolate for replacement or redesign.
* Robustness: Errors within individual page components are typically not isolated, resulting in full-page errors.
* Clear organization: Guidelines for CSS, JS, and HTML code file organization are often missing.

The lack of clear design often leads to a disordered codebase, which is challenging to maintain and enhance.

### Benefits of PageMaker
Our design approach offers:
* Shared top-level responsive design templates across pages and projects.
* Shareable medium-level widgets between pages and projects.
* Enhanced understanding of project layout and modification procedures.
* Fewer ad-hoc modifications and arduous bug fixes when adding or altering features.

## CSS Design with PageMaker
We recommend segmenting CSS files into:
* Layouts: To control positioning and spacing.
* Themes: To manage color schemes.

## Frequently Asked Questions
### Why not use single-page apps?
Most applications do not fit the single-page app model. Forcing them into such a design eliminates the advantage of stateless page loads, akin to stuffing all your code into a single object. 

PageMaker encourages you to decompose your application into separate, naturally occurring pages, managed through a menu or state machine, offering a well-structured user navigation experience.

### How is PageMaker like object-oriented CSS?
[Object-oriented CSS](https://github.com/stubbornella/oocss/wiki) is a system of CSS organization developed by Nicole Sullivan in 2009. In her design, a CSS object consists of:
* HTML nodes in the DOM
* CSS declarations about those nodes
* Related components like images
* JavaScript associated with the object

The CSS declarations all begin with the class name of the wrapper node. We both have similar ideas about building web pages from modular, reusable CSS. Some differences include:
* Her ideas are intended for graphical designers to use when hand-coding CSS. My ideas are intended to use as a conceptual and practical framework developers when coding pages for complex projects.
* She doesn't use IDs for any content, including top-level page containers, under the theory that someone might what to have more than one header or footer. I specify the use of particular IDs for top-level containers because top-level containers need to be styled as a page layout and because a header or footer is now a semantic HTML tag that can consist of one or more sections, so we don't need multiple headers or footers.
* Her ideas are about sharing styles within a single project. My ideas are to allow the same thing as well as sharing components within multiple projects. This is enabled by the layered architecture which separates the top-level page organization from the widgets and by the complete separation of the widgets.
* As a designer, she doesn't specify anything about JavaScript organization. I specify the same wrapper class requirement for JavaScript code as the CSS.
* As a designer, she doesn't specify anything about the file organization of the CSS, JS, or HTML. I specified that files are independent units with the widget name, which allows versioning, replacing, and sharing content by the clean separation of files.
* As a designer, she doesn't specify how the HTML content is built. I specify a widget-builder class that can use templating systems to build each independent unit of HTML while catching its errors.
