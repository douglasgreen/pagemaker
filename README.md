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
