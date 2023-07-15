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
[Object-oriented CSS (OOCSS)](https://github.com/stubbornella/oocss/wiki) is a method of organizing CSS introduced by Nicole Sullivan in 2009. According to Sullivan's design, a CSS object is comprised of:
* HTML nodes in the DOM
* CSS declarations for these nodes
* Relevant components like images
* JavaScript connected with the object

All CSS declarations in OOCSS begin with the wrapper node's class name. There is a degree of overlap between Sullivan's OOCSS and our PageMaker's philosophy, especially in building web pages using modular and reusable CSS. However, several key differences separate our design approach:

* **Target Audience**: OOCSS is designed for graphic designers hand-coding CSS, whereas PageMaker is intended for developers working on complex projects, providing both a conceptual and practical framework.
* **Usage of IDs**: OOCSS does not employ IDs for any content, including top-level page containers, to allow multiple headers or footers. In contrast, PageMaker specifies IDs for top-level containers, as these require unique styling for page layouts. Also, with the semantic HTML tags, a header or footer can comprise multiple sections, eliminating the need for multiple headers or footers.
* **Style Sharing**: Sullivan's OOCSS focuses on sharing styles within a single project. PageMaker extends this concept, allowing not just intra-project style sharing, but also inter-project component sharing. This is facilitated by our layered architecture that separates top-level page organization from the widgets and ensures their complete isolation.
* **JavaScript Organization**: As a designer, Sullivan does not outline any specifications in OOCSS for JavaScript organization. Conversely, PageMaker applies the same wrapper class requirement to JavaScript code as it does to CSS.
* **File Organization**: OOCSS does not provide guidelines on the organization of CSS, JS, or HTML files. In contrast, PageMaker prescribes an unambiguous file organization strategy, where files are standalone units named after the widget they represent, thus allowing easier versioning, replacement, and content sharing through clean separation of files.
* **HTML Content Construction**: In OOCSS, no instructions are provided for building HTML content. PageMaker, on the other hand, defines a widget-builder class that employs templating systems to construct each independent HTML unit while managing its error handling.

### How is PageMaker different from semantic CSS?
CSS selector naming usually falls under one of two systems:
* **Feature-based system**: Here, selector names represent independent features such as color, size, or layout. Selectors carry adjective-like names like `.yellow`, `.large`, or `.centered`, and each element receives a combination of these tags.
* **Semantic system**: In this approach, selector names represent what the element stands for. Therefore, selectors carry noun-like names such as `.menu`, `.submitButton`, or `.search`, with a single name applied to each element, denoting its identity.

Each approach has its benefits. Let's take Bootstrap as an example: it employs the semantic approach when specifying types of elements, such as `.container` or `.table`. But it also utilizes feature descriptors where they make sense to combine individual features, like `.active`, `.align-top`, or color references like `success`.

PageMaker's approach begins with segmenting the page into widgets. Each widget, being a segment of a page, receives a semantic noun-like name such as `.menu`. This widget name is then employed as a top-level selector for the rest of the names, adding specificity. The naming of selectors within the widget becomes a local concern and can be flexibly managed using either adjectives or nouns, as needed. For instance, menu selectors could be labeled as features like `.menu .yellow` or as objects like `.menu .link`.

This system can be integrated with a flexible selector-defining mechanism similar to Bootstrap's approach, proving most effective when selectors are applied specifically upon class application. Because class selectors are applied only on request, they don't conflict with the widget definitions. This can enable defining a global vocabulary of color terms, preferred fonts, or related styles for a particular site that can be shared between widgets or page containers.
