# Namespaces

Put classes with static methods in a Utility namespace so they are easy to find.

All methods in the Utility namespace should be static. All methods outside the utility namespace should be non-static. Don't mix static and non-static methods in the same class.

All namespaces should be singular.

Prefer abstract names for namespaces: e.g. the Validator class in the Validation namespace and Routing\Router.

A namespace can also be named after the thing being managed, e.g. File or Database.

So a namespace should fill in the blank "I am doing _____ or managing a/an _____".
