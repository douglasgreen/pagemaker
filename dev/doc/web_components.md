# Web Components

PageMaker tries to solve a similar problem as web components. Web components solve it with cooperation from the browser makers. They use JavaScript to define independent area of the page that reset their styles so that they can add new styles. This is an attempt to add modularity to the webpage and compensate for the defects in the CSS design.

Web components were only recently implemented in browsers. They have a reputation for being slow and having a poor API.

Page Maker solves the same problem with logical organization so that web components are needed. This is faster and doesn't require a special API. It is done with native CSS, HTML, and JavaScript. Each of these are separated into containers labeled by a widget class. Because the page is organized in layers in a modular fashion, the styles don't conflict with each other and don't require a reset. So web components aren't needed.
