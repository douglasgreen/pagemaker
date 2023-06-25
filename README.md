# pagemaker
PHP microframework 

## Design goals
* All functions without $this are static.
* Code is simple enough to read.
* Container.
* Dependency injection.
* File location in hierarchy by generality (higher is more general).
* Lightweight and efficient.
* Minimal coupling. Pass scalars not classes as arguments.
* No dependencies.
* No session abuse (objects shouldn't be stored in sessions).
* No writable static properties.
* Organized JS and CSS by class or ID.
* Prefab components.
* Support UUID, versioning, and uploads in database.
* Type hints everywhere.
* Ugly URLs for routing. Named parameters are better.
* Work on CLI, JSON, or HTML.

## Page layout
The body is a series of rows.

<body id="body">
    <header id="header">
        <div id="banner">
            <div id="logo"></div>
            <div id="searchBar"></div>
            <div id="iconBar"></div>
        </div>
        <nav id="menu"></nav>
    </header>
    <nav id="leftNav"></nav>
    <main id="main">
        <section class="section"></section>
        <section class="section"></section>
        ...
    </main>
    <nav id="rightNav"></nav>
    <footer id="footer"></footer>
</body>

## CSS
Only three queries:
* Small: < 600px
* Medium: 600px - 1200px
* Large: > 1200px

## Router
* Each namespace has its own front controller index.php.
* Pass a parameter `route=name_action` like `route=customer_view`.
* A class in that namespace will call the method CustomerController::getView() or CustomerController::postView().
