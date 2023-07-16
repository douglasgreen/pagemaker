# Introducing PageMaker
A Revolutionary PHP Microframework

## Overview
Web applications are fundamentally a collection of web pages. A well-structured web page is a product of a thoughtful and logical design approach. This includes:
* Hierarchical design: Top-level page containers, intermediate-level widgets, and small-scale widget features.
* Modular architecture: Divide the application into independent widgets, each encapsulating its own CSS, JS, and HTML templates.
* Information hiding: The style of top-level CSS and JS selectors hides information about their internal organization and presents a smaller API.
* Plug-in architecture: Widgets operate independently, allowing their errors to be identified and handled separately.
* Unambiguous file organization: Each widget is represented by its distinct set of CSS, JS, and HTML template files.

## Building Pages with PageMaker
### Top-Level Containers and Sections
The PageMaker microframework facilitates the construction of a web page's top-level structure via the Page class, which generates standard containers:
* `<header>`: Potential housing for logo, search bar, icon links, and menu navbar.
* `<main>`: The primary content of the page.
* `<footer>`: Likely contains link columns and copyright information.

These containers are identified through unique classes: `pmHeader`, `pmMain`, `pmFooter`. They are organized using a grid layout and stylized with CSS in a `pmPage.css` file. 

Our emphasis on standard classes is a testament to PageMaker's commitment to clear, project-specific organization. CSS and JS should target these classes to avoid unwanted styling. Thus, a well-constructed `pmPage.css` file should only contain top-level styles targeting these container classes.

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
Each widget is composed of one or more divs, encapsulated within its container and deployed using a flexbox layout. The task of rendering is carried out by the widget itself since it is a matter of local concern.

Given their self-contained nature, widgets can exercise considerable flexibility in their design. For instance, the CSS within a widget can employ information encapsulation by utilizing tag selectors inside the top-level class selector.

* `.myWidget p` - This styles all 'p' tags within the widget, negating the need for a subclass designation.
* `.myWidget .mySubclass` - By using a subclass, you can expose it to the widget's CSS API where it's implemented in the HTML.
* `.myWidget` comprising inline styles - This can be a viable approach when there's certainty that the CSS won't need to be reused within the widget.

Each widget comprises one or more divs rendered within its container using a flexbox. The widget itself performs the rendering because it pertains to local concerns.

### Comparison with Typical Design
The conventional web design lacks:
* Layering: Absence of clear separation of various webpage features at different scales.
* Modularity: JS and CSS often intermingle, making individual features hard to isolate for replacement or redesign.
* Robustness: Errors within individual page components are typically not isolated, resulting in full-page errors.
* Information hiding: Every CSS tag and JS event is exposed at the global level.
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
### How is CSS poorly designed and how can we do better?
CSS, with its peculiar specificity rules, operates on a system that assigns scores to different types of selectors:
* !important = top priority
* Inline styles = 1000 points
* IDs = 100 points
* Classes = 10 points
* Tags = 1 point

However, this system seems counterintuitive and problematic for two main reasons.

Firstly, IDs are often assigned to high-level page elements, while classes are typically linked to lower-level elements. This hierarchy complicates the process of overwriting global styles with more specific, widget-level styles.

Secondly, the current design makes coordination between third-party stylesheets more challenging. The absence of a well-defined system for establishing precedence among stylesheets, apart from manipulating individual style weights, further complicates matters.

A more efficient design for CSS would rely on simple precedence rules rather than weight-based specificity. That is, the most recently applied selector would always take priority. Implementing such a change could address the two design issues mentioned earlier:

1. It would allow for the semantic application of IDs or classes, eliminating concerns about their specificity weights and the need for later overwrites. Therefore, IDs could naturally be used for top-level page containers, with the ability to be overridden by lower-level page classes.
2. The precedence of third-party stylesheets would be determined by the order in which they were applied, enabling more streamlined coordination.

In the absence of a well-designed CSS system, a practical solution would be to stick exclusively to top-level class-based selectors. By avoiding the use of !important and ID-based selectors, most problems can be mitigated, given that all selectors would then operate at the same level of specificity. Within a widget:
* Tags can be used as selectors inside top-level class selectors without affecting urelated usage of the tags in other widgets.
* Inline styles can be used because they are always applied last so they don't violate the precedence rule.

### How is JS poorly designed and how can we do better?
JavaScript is a programming language that was hastily put together and gradually refined over years via a committee-led process. Its fundamental design leaves much to be desired, marked by issues such as:

* Output Dependency Issues: Operations functioning at the output layer, leading to browser inconsistencies and fragility due to an over-reliance on specific document formats instead of managing data in a more universal manner.
* Error Handling Deficiencies: Subpar error handling and reporting which operates at the user level rather than at the server level.
* Race Condition Challenges: Race conditions brought on by an inadequately designed event model tied to element rendering.
* Dependency Stack Complications: Excessive rotation, bloat, and intricacy within the dependency stack.
* Language Misfeatures: Various other language shortcomings outlined in the book 'JavaScript: The Good Parts'.

Furthermore, it also shares a common problem with CSS - the lack of an effective organization system, albeit without the specificity hierarchy. To my knowledge, none of the visual designers who laid down the CSS standards examined here took any initiative to develop similar JavaScript standards. Nevertheless, PageMaker addresses this organizational deficit with the widget system, co-organizing CSS and JavaScript into widgets. Be aware that this system doesn't inherently resolve any of the problems listed above. Therefore, it is advised to restrict the use of JavaScript to specific page animation requirements that don't involve reloading the page.

Future iterations of PageMaker may attempt to rectify some of these issues with:

* Output Dependency Issues: Systematized data retrieval methods to eliminate the need for excessive data encoding within the page.
* Error Handling Deficiencies: Refined error handling mechanisms that log errors server-side for developer examination.
* Race Condition Challenges: The introduction of an event queuing system for each widget to prevent race conditions and facilitate cooperative development of event handlers.
* Dependency Stack Complications: Minimization of JavaScript dependencies by formulating simple, ad hoc alternatives.
* Language Misfeatures: Formulation or adoption of a simplistic JavaScript style guideline to sidestep language misfeatures.

### Why not use Symfony or some other framework?
Why not opt for Symfony or a similar framework? While powerful in their own right, tools like Symfony aren't explicitly aimed at addressing the page-specific challenges that PageMaker seeks to solve. Symfony lacks an inbuilt page builder, likely because it anticipates developers will create their own page structures. As such, PageMaker's page layout solution should be compatible with Symfony. Each component of PageMaker is designed to function independently, making them amenable to customisation or co-use with other frameworks like Symfony.

### Why not use Twig or PHPTAL for page layout?
So, why not use Twig or PHPTAL for page layout? In this architecture, PageMaker is employed to construct the page, primarily because it's merely a simple collection of top-level HTML5 semantic tags. You're free to use Twig or PHPTAL to structure the content of each widget or simply lay them out as HTML using PHP's inherent templating feature. PageMaker presents an advancement over using Twig directly, as it assists in arranging the JavaScript, CSS, and templates in a more organized manner than Twig alone offers. Twig anticipates that you'll handle your own organization, but PageMaker simplifies that process.

### Why not use single-page apps?
Most applications do not fit the single-page app model. Forcing them into such a design eliminates the advantage of stateless page loads, akin to stuffing all your code into a single object. 

PageMaker encourages you to decompose your application into separate, naturally occurring pages, managed through a menu or state machine, offering a well-structured user navigation experience.

### How is PageMaker different from OOCSS?
[Object-oriented CSS (OOCSS)](https://github.com/stubbornella/oocss/wiki) is a method of organizing CSS introduced by Nicole Sullivan in 2009. According to Sullivan's design, a CSS object is comprised of:
* HTML nodes in the DOM
* CSS declarations for these nodes
* Relevant components like images
* JavaScript connected with the object

All CSS declarations in OOCSS begin with the wrapper node's class name. There is a degree of overlap between Sullivan's OOCSS and our PageMaker's philosophy, especially in building web pages using modular and reusable CSS. However, several key differences separate our design approach:

* **Target Audience**: OOCSS is designed for graphic designers hand-coding CSS, whereas PageMaker is intended for developers working on complex projects, providing both a conceptual and practical framework.
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

### How is PageMaker different from atomic CSS?
Atomic CSS, characterized by its adjective-based selectors, stands in contrast to semantic CSS, which primarily utilizes noun-based selectors. The driving principle behind atomic CSS is backend redundancy reduction. When the same style feature is applied across multiple elements, atomic CSS avoids CSS bloat by reusing single-purpose classes rather than duplicating style declarations. Semantic CSS, on the other hand, aims at frontend simplicity, where a single class applied to an element encapsulates all its style features.

Both these strategies come with their distinct advantages, and it's unnecessary to constrain your CSS selectors to one extreme: solely adjectives or nouns.

PageMaker organizes CSS into top-level container widgets. This structure shouldn't contribute to HTML verbosity, given the possibility of using any selector type within the top-level container class, as it applies only to that specific widget. Both adjective-based and noun-based selectors can be employed inside the widget. 

While this setup may cause some CSS duplication if you want to share code between widgets, the benefits of independent widget modification arguably offset any such 'bloat'. Essentially, PageMaker embraces the strengths of both atomic and semantic CSS, providing a versatile, robust approach to web design.

### How is PageMaker different from SMACSS?
Scalable and Modular Architecture for CSS (SMACSS) is a CSS organization scheme proposed by Jonathan Snook in 2011, bearing similarities to Object-oriented CSS (OOCSS) in terms of focusing primarily on CSS styling rather than project organization. Indeed, OOCSS served as one of the sources of inspiration for SMACSS.

* **Base Rules**: In contrast to SMACSS, we don't endorse the use of base rules defined by HTML tag selectors. Given the variety in the usage of different types of tags, assigning style based on tag selection isn't advisable. Instead, we encourage confining all style definitions to class-based selectors.
* **Layout Rules**: Our approach to layout rules resembles SMACSS, but with the added advantages of semantic HTML and grid layout to aid the process.
* **Module Rules**: These rules find an echo in our widget-based system. However, our widgets are conceptualized as self-contained entities that encompass JavaScript, CSS, templates, and other assets. This makes them highly portable between different pages and projects.
* **State Rules**: These rules represent the various states a widget can have, and are thus defined as part of the widget itself in our system.
* **Theme Rules**: We perceive these as integral to the top-level design since each widget is expected to bring along its own styling.

In summary, while PageMaker acknowledges the strengths of SMACSS, it furthers the approach by emphasizing modular design, where widgets encapsulate all the necessary resources, enhancing the portability and ease of customization.
