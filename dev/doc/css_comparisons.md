## CSS Comparisons

### Comparing PageMaker and OOCSS

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

### Comparing PageMaker and Semantic CSS

CSS selector naming usually falls under one of two systems:
* **Feature-based system**: Here, selector names represent independent features such as color, size, or layout. Selectors carry adjective-like names like `.yellow`, `.large`, or `.centered`, and each element receives a combination of these tags.
* **Semantic system**: In this approach, selector names represent what the element stands for. Therefore, selectors carry noun-like names such as `.menu`, `.submitButton`, or `.search`, with a single name applied to each element, denoting its identity.

Each approach has its benefits. Let's take Bootstrap as an example: it employs the semantic approach when specifying types of elements, such as `.container` or `.table`. But it also utilizes feature descriptors where they make sense to combine individual features, like `.active`, `.align-top`, or color references like `success`.

PageMaker's approach begins with segmenting the page into widgets. Each widget, being a segment of a page, receives a semantic noun-like name such as `.menu`. This widget name is then employed as a top-level selector for the rest of the names, adding specificity. The naming of selectors within the widget becomes a local concern and can be flexibly managed using either adjectives or nouns, as needed. For instance, menu selectors could be labeled as features like `.menu .yellow` or as objects like `.menu .link`.

This system can be integrated with a flexible selector-defining mechanism similar to Bootstrap's approach, proving most effective when selectors are applied specifically upon class application. Because class selectors are applied only on request, they don't conflict with the widget definitions. This can enable defining a global vocabulary of color terms, preferred fonts, or related styles for a particular site that can be shared between widgets or page containers.

### Comparing PageMaker and Atomic CSS

Atomic CSS, characterized by its adjective-based selectors, stands in contrast to semantic CSS, which primarily utilizes noun-based selectors. The driving principle behind atomic CSS is backend redundancy reduction. When the same style feature is applied across multiple elements, atomic CSS avoids CSS bloat by reusing single-purpose classes rather than duplicating style declarations. Semantic CSS, on the other hand, aims at frontend simplicity, where a single class applied to an element encapsulates all its style features.

Both these strategies come with their distinct advantages, and it's unnecessary to constrain your CSS selectors to one extreme: solely adjectives or nouns.

PageMaker organizes CSS into top-level container widgets. This structure shouldn't contribute to HTML verbosity, given the possibility of using any selector type within the top-level container class, as it applies only to that specific widget. Both adjective-based and noun-based selectors can be employed inside the widget. 

While this setup may cause some CSS duplication if you want to share code between widgets, the benefits of independent widget modification arguably offset any such 'bloat'. Essentially, PageMaker embraces the strengths of both atomic and semantic CSS, providing a versatile, robust approach to web design.

### Comparing PageMaker and SMACSS

Scalable and Modular Architecture for CSS (SMACSS) is a CSS organization scheme proposed by Jonathan Snook in 2011, bearing similarities to Object-oriented CSS (OOCSS) in terms of focusing primarily on CSS styling rather than project organization. Indeed, OOCSS served as one of the sources of inspiration for SMACSS.

* **Base Rules**: In contrast to SMACSS, we don't endorse the use of base rules defined by HTML tag selectors. Given the variety in the usage of different types of tags, assigning style based on tag selection isn't advisable. Instead, we encourage confining all style definitions to class-based selectors.
* **Layout Rules**: Our approach to layout rules resembles SMACSS, but with the added advantages of semantic HTML and grid layout to aid the process.
* **Module Rules**: These rules find an echo in our widget-based system. However, our widgets are conceptualized as self-contained entities that encompass JavaScript, CSS, templates, and other assets. This makes them highly portable between different pages and projects.
* **State Rules**: These rules represent the various states a widget can have, and are thus defined as part of the widget itself in our system.
* **Theme Rules**: We perceive these as integral to the top-level design since each widget is expected to bring along its own styling.

In summary, while PageMaker acknowledges the strengths of SMACSS, it furthers the approach by emphasizing modular design, where widgets encapsulate all the necessary resources, enhancing the portability and ease of customization.
