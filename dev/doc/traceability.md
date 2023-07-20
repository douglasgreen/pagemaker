## Traceability

PageMaker is designed to be traceable from the front end to the back end. You should be able to look at a front and component and figure out where it is coming from. This is accomplished by:
* A layered design that separates high-level page arrangement from medium-level widgets. When those features are mixed together, it makes finding your code more difficult.
* A modular design that separates widgets into independent components of JS, CSS, and templates. Each component is designed to be a self-contained as possible, not only in their effects on the page but also in their file location. So you should be able to head straight to the files for a component.
* A router that routes to a predefined class and method system. So you should be able to look at a route and go straight to the code.

Achieving traceability by design also helps:
* Make debugging easier by reducing conflicts.
* Site feature identification by being able to make a list of widgets.
* Code reuse by copying modules from page to page and from project to project.
* Code cleanup by deleting unused widgets.
