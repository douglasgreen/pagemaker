## Versioning
All code and content is versioned, including public and private.

The initial version is dev. Major release versions are v1, v2, etc.

Content is versioned by placing it into a directory with that version.

Autoload is versioned by using the version name in the path:

```json
"autoload": {
    "psr-4": {
        "PageMakerDev\\": "dev/app/",
        "PageMakerV1\\": "v1/app/"
    }
},
```

The major composer version is the maximum of the major release versions.

Any component that depends on a major release version must be upgraded to that release version.
