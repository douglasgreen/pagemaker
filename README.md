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

<body id="pmBody">
    <header id="pmHeader">
        <div id="pmBanner">
            <div id="pmLogo"></div>
            <div id="pmSearchBar"></div>
            <div id="pmIconBar"></div>
        </div>
        <nav id="pmMenu"></nav>
    </header>
    <nav id="pmLeftNav"></nav>
    <main id="pmMain">
        <section class="pmSection"></section>
        ...
    </main>
    <nav id="pmRightNav"></nav>
    <footer id="pmFooter"></footer>
</body>

