# pagemaker
PHP microframework 

## Introduction
Web apps are built out of web pages. A web page should be built with a logical design. This involves:
* Layered design, into top-level page containers, medium-level widgets, and small level features of widgets.
* Modular design, where the app is split into widgets each with their own CSS, JS, and HTML templates in their own namespace.
* Plug-in architecture, where the widgets are executed independently so that their errors can be caught.
* Clear file organization, where each widget is its own set of JS, CSS, and HTML template files.

## Page design
### Top-level containers and sections
The top level of the page is a set of typical containers built by the Page class.
* &lt;header&gt; tag, which might contain logo, search bar, icon links, and menu navbar
* &lt;main&gt; tag, which is the main content of the page
* &lt;footer&gt; tag, which probably contains some columns with links and a copyright

The containers are identified with IDs:
* &lt;header id="pmHeader"&gt;
* &lt;main id="pmMain"&gt;
* &lt;footer id="pmFooter"&gt;

These are laid out with a grid and other CSS styles in a file that should be called pmPage.css.

The use of standard IDs is a signal that the project's organization scheme is being used. CSS and JS should explicitly target the ID rather than the generic tag to avoid styling elements when not requested. So a well-designed pmPage.css file should consist only of top-level styles that target these container IDs.

The top-level containers are broken down into sections, each identified with a class. These include:
* article
* aside
* nav
* section

### Medium-level widgets
The medium level of the page consists of a series of widgets. The widgets extend the Widget class and are render as &lt;section class="myWidget"&gt; tags where myWidget is the name of the widget.

The widget is treated as a plug-in. When the widget is rendered, its errors are caught and displayed in the widget section so the page is modular and robust.

The widget contains its own JS and CSS code files along with any HTML templates such as Twig or PHPTAL templates or basic PHP HTML (.phtml) templates. They are organized into separate files for each widget:
* myWidget.js
* myWidget.css
* myWidget.phtml or myWidget.twig

The JS and CSS files are considered well-designed when their top-level selector is .myWidget, which is the name of the widget class applied to its &lt;section class="myWidget&gt; tag.

This arrangements makes the widgets independent and modular and minimizes conflicts. You can rearrange widgets in a page, change them, or replace them freely. You should also be able to copy widgets from project to project as long as they use the same page-building scheme.

Because the widget is actually just a thin wrapper, it can execute any sort of third-party code including the rendering of third-party components.

### Low-level divs
Each widget should consist of one or more divs rendered with a flexbox inside its container. The rendering is done by the widget itself because it is a local concern.

### Comparison with typical design
Typical web design is:
* Not layered, so there is no clean separation of different webpage features at different scales.
* Not modular, so JS and CSS are all mixed together, making individual features hard to separate for replacement or redesign.
* Not robust, because errors and individual page components are typically not caught or rendered as a whole page error.
* Not clearly organized, because there are no guidelines about what files to put JS, CSS, and HTML code into.

The absence of clear design leads to a disorganized mess of code that is hard to maintain and enhance.

### Benefits of this design
This design allows:
* Top-level responsive design templates to be shared between pages and projects.
* Medium-level widgets to be shared between pages and projects.
* Easier comprehension of the project layout and modification process.
* Reduce ad-hoc modifications and tedious bug fixes when adding or changing features.

## CSS design
The CSS files should be split into:
* Layouts, that control position and spacing
* Themes, that control color

## Q&A
### Why not use single-page apps?

Most apps don't fit the single-page app profile. If you force them into a single-page design, you lose the benefit of having stateless page loads. That's like putting all your code into a God object.

It is better to decompose your app into naturally separate pages and give them a menu or state machine that moves the user between pages in an organized manner.
