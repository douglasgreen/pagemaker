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
