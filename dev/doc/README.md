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

### Benefits of PageMaker
Our design approach offers:
* Shared top-level responsive design templates across pages and projects.
* Shareable medium-level widgets between pages and projects.
* Enhanced understanding of project layout and modification procedures.
* Fewer ad-hoc modifications and arduous bug fixes when adding or altering features.

## Frequently Asked Questions
### How is CSS poorly designed and how can we do better?
CSS, with its peculiar specificity rules, operates on a system that assigns scores to different types of selectors:
* !important = top priority
* Inline styles = 1000 points
* IDs = 100 points
* Classes = 10 points
* Tags = 1 point

However, this system seems counterintuitive and problematic for two main reasons.
1. IDs are often assigned to high-level page elements, while classes are typically linked to lower-level elements. This hierarchy complicates the process of overwriting global styles with more specific, widget-level styles.
2. The current design makes coordination between third-party stylesheets more challenging. The absence of a well-defined system for establishing precedence among stylesheets, apart from manipulating individual style weights, further complicates matters.

A more efficient design for CSS would rely on simple precedence rules rather than weight-based specificity. That is, the most recently applied selector would always take priority. Implementing such a change could address the two design issues mentioned earlier:
1. It would allow for the semantic application of IDs or classes, eliminating concerns about their specificity weights and the need for later overwrites. Therefore, IDs could naturally be used for top-level page containers, with the ability to be overridden by lower-level page classes.
2. The precedence of third-party stylesheets would be determined by the order in which they were applied, enabling more streamlined coordination.

In the absence of a well-designed CSS system, a practical solution would be to stick exclusively to top-level class-based selectors applied to widgets. By avoiding the use of !important and ID-based selectors, most problems can be mitigated, given that all selectors would then operate at the same level of specificity. And within each widget:
* Tags can be used as selectors inside the top-level class selector of the widget without affecting unrelated usage of the tags in other widgets.
* Inline styles can be used because they are always applied last so they don't violate the precedence rule.
* Information hiding and code brevity are achieved because the widget class can apply complex substyles without needing to specify their subclass names.

### How is JS poorly designed and how can we do better?
JavaScript is a programming language that was hastily put together and gradually refined over years via a committee-led process. Its fundamental design leaves much to be desired, marked by issues such as:

* **Output Dependency Issues**: Operations functioning at the output layer, leading to browser inconsistencies and fragility due to an over-reliance on specific document formats instead of managing data in a more universal manner.
* **Error Handling Deficiencies**: Subpar error handling and reporting which operates at the user level rather than at the server level.
* **Race Condition Challenges**: Race conditions brought on by an inadequately designed event model tied to element rendering.
* **Dependency Stack Complications**: Excessive rotation, bloat, and intricacy within the dependency stack.
* **Language Misfeatures**: Various other language shortcomings outlined in the book 'JavaScript: The Good Parts'.

Furthermore, it also shares a common problem with CSS - the lack of an effective organization system, albeit without the specificity hierarchy. To my knowledge, none of the visual designers who laid down the CSS standards examined here took any initiative to develop similar JavaScript standards. Nevertheless, PageMaker addresses this organizational deficit with the widget system, co-organizing CSS and JavaScript into widgets. Be aware that this system doesn't inherently resolve any of the problems listed above. Therefore, it is advised to restrict the use of JavaScript to specific page animation requirements that don't involve reloading the page.

Future iterations of PageMaker may attempt to rectify some of these issues with:

* **Output Dependency Issues**: Systematized data retrieval methods to eliminate the need for excessive data encoding within the page.
* **Error Handling Deficiencies**: Refined error handling mechanisms that log errors server-side for developer examination.
* **Race Condition Challenges**: The introduction of an event queuing system for each widget to prevent race conditions and facilitate cooperative development of event handlers.
* **Dependency Stack Complications**: Minimization of JavaScript dependencies by formulating simple, ad hoc alternatives.
* **Language Misfeatures**: Formulation or adoption of a simplistic JavaScript style guideline to sidestep language misfeatures.

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

### Can PageMaker be used with Symfony or other frameworks?
While Symfony serves as a powerful tool for web application development, it doesn't directly address the page-specific challenges that PageMaker is designed to solve. Symfony, by design, doesn't provide an in-built page builder as it assumes developers will devise their own page structures. Given this, PageMaker's layout solution can work harmoniously with Symfony. PageMaker's components are independently designed, enabling them to be overridden or used together with other frameworks like Symfony, enhancing the functionality and flexibility of your web development process.

### Can PageMaker be used with Twig or other page layout libraries?
When it comes to page layout, one may question the compatibility of PageMaker with Twig or PHPTAL. Within this architecture, PageMaker serves as the tool to build the page structure, using a simple collection of top-level HTML5 semantic tags. You have the option to utilize Twig or PHPTAL to craft the content of each widget or simply design them as HTML leveraging PHP's built-in templating feature. By integrating PageMaker, you are upgrading from Twig's direct usage as it facilitates the arrangement of JavaScript, CSS, and templates in a more systematic way than Twig in isolation. While Twig anticipates that you'll manage your own organization, PageMaker streamlines this process, making your layout tasks more efficient and effective.

### Why not use single-page apps?
While single-page applications (SPAs) can offer a smooth and responsive user experience, they are not always the optimal solution. Trying to mold all applications into this design paradigm can inadvertently forego the benefits of stateless page loads, mirroring the convoluted process of cramming your entire codebase into a god object.

One of the core principles of SPAs, the absence of page refreshes, essentially leads to an aggregation of all your JavaScript into a bulky, cumbersome entity. Moreover, it perpetuates the global state of your application in JavaScript over the entire runtime of your web app, adding layers of complexity to your application design.

PageMaker, on the other hand, advocates for the disintegration of your application into distinct, intuitively structured pages. These pages can be navigated via a menu or a state machine, providing a user navigation experience that is both clear and efficient. The majority of the page rendering should be undertaken using direct database queries and PHP templating, reserving JavaScript for on-page animations and utilizing a limited local state that refreshes upon every page load. This approach results in a more organized and manageable application design, keeping complexity in check.

### Why not use REST APIs?
REST APIs are often misused, employed as a code organization tool when in reality, they're intended as units of network architecture. Microservices are even worse because they break down services into granular units that are too small.

In the past, it was common to build unstructured PHP monoliths. Over time, these were swapped out in favor of REST APIs. However, a better approach would have been to use namespaces and autoloading, a pair of advanced structural tools provided in newer versions of PHP.

Before deciding to use REST APIs, it's crucial to weigh their advantages and disadvantages.

The **benefits** of REST APIs include:

* **Language Compatibility:** They can be called by a variety of programming languages.
* **Dynamic Page Interaction:** They can be employed for interactive page features without necessitating a page reload.
* **Server Load Distribution:** If your server is at capacity, REST APIs can be used to divide services between multiple servers.

However, the **drawbacks** of REST APIs shouldn't be overlooked:

* **Performance:** REST APIs operate slower than direct database access.
* **Code Overhead:** They require additional layers of code for their production and consumption.
* **Network Delays and Reliability:** Network delays and reliability issues are introduced.
* **Data Fragmentation:** Your databases can become unnecessarily divided between different servers and APIs.

These drawbacks can be significant, leading to situations where avoiding a REST API could be more beneficial. You might not need a REST API if:

* **Single Server-side Language Use:** You are only using one server-side programming language, such as PHP.
* **Modular Structure:** Your objective is to grant your application a modular structure, which can be achieved using namespaces and autoloading.
* **Versioning:** Your need is for versioning, which can be realized with Composer versioning or content versioning.
* **Database Lookup:** If your requirement is merely a database lookup for some associated value, a direct SQL join would suffice.
* **Database Capacity:** If your database is at its limit, the solution is to utilize multiple database hosts rather than multiple service hosts.

### Why not use virtual machines?
The prevalent trend of employing virtual machines (VMs) in modern development deserves thoughtful examination. Both the overuse of VMs and REST APIs seem to stem from a flawed understanding: the belief that dissecting an architecture into smaller parts automatically simplifies it. This, however, isn't necessarily true.

A well-designed system should be easy to explain, understand, and modify. To demonstrate, let's contrast two types of system: a shared development server and a group of VMs. Here, we'll assume that the shared server was initially established by the Networking Department and subsequently replaced by VMs. These VMs are running 10 unique projects for 10 different developers, coordinated by DevOps, with individual developers also establishing their own VMs.

* **Shared Development Server:** This system is relatively straightforward to describe, likely running a single PHP version and one or multiple versions of Node, jQuery, or related libraries. Its configuration includes a single host and a database server. This simplicity in description and maintenance is a key advantage. The Networking Department, rather than developers, generally oversees it, adhering to the principle of specialization.

* **Virtual Machines (VMs):** In contrast, VMs are more complex to describe. Given that the 10 developers could each check out multiple VMs, there could be hundreds of unique VM configurations. Each one possesses its own PHP, Node, and jQuery version, requiring intricate coordination for the setup and configuration of these distinct environments. Additionally, each developer has to manage the setup, operation, and troubleshooting of these VMs—a task previously undertaken by specialists.

The shift to VMs often leads to a scenario where each individual part is less complex, but the overall system becomes much more intricate.

Similarly, REST APIs have the same issue. Segmenting code into separate REST APIs may make the APIs appear simpler. Yet, to fully describe them, you must also account for access credentials, the layers producing and consuming the API, and the network's condition. This results in a system that, while comprised of simpler components, becomes more complex and brittle in its entirety. Dividing the complexity of a whole project into separate parts doesn't eliminate complexity; it can actually enhance it.

Generally, it's likely preferable to begin with an organized monolithic architecture on shared development server, only opting to segment the design for specific reasons, such as exceeding the capacity of a single server.
