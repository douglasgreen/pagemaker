# Comprehensive versioning

## Overview

In the PageMaker system of internal versioning, every piece of code and content, whether public or private, is subjected to versioning. This ensures traceability, manageability, and backward compatibility.

- **Initial Version**: The project starts with a 'dev' version, indicating a development or pre-release stage.
- **Major Releases**: As the project matures, major releases are versioned as v1, v2, and so on.
- **Directory-based Versioning**: Each version of the content is placed in a separate directory named after that version. This provides a clear separation and organization of content based on versions.
- **Autoload Versioning**: The versioning extends to the autoload configuration. The version name is used in the path to determine which version of the code should be loaded. For instance, the `PageMakerDev\\` namespace points to the `dev/app/` directory, while `PageMakerV1\\` points to the `v1/app/`.
- **Composer Versioning**: The major version in the composer is set to the highest major release version available.
- **Dependency Management**: Any component that relies on a particular major release version must be updated to that version. This ensures compatibility and reduces the risk of breaking changes.

## Comparison to REST API Versioning

REST API versioning is a strategy used to manage changes in APIs over time without breaking the applications that depend on them.

- **URI Versioning**: The most common method where the version number is included in the URI, e.g., `/v1/users`.
- **Header Versioning**: The version information is sent in the request header.
- **Parameter Versioning**: The version is passed as a parameter in the request.
- **Media Type Versioning**: The version is included in the accept header, specifying a custom media type.

## Pros and Cons

**Pros of Internal Content Versioning**
1. **Clear Organization**: By segregating content based on versions, it's easier to locate and manage specific versions of the content.
2. **Backward Compatibility**: Older versions of the content remain accessible, ensuring that any system depending on an older version isn't broken.
3. **Flexibility**: Components can be upgraded individually, allowing for gradual updates.

**Cons of Internal Content Versioning**
1. **Complexity**: Managing multiple versions can become complex, especially when there are dependencies between components.
2. **Storage Overhead**: Storing multiple versions can lead to increased storage requirements.

**Pros of REST API Versioning**
1. **Consistency**: Clients know what to expect from the API, regardless of the changes in the backend.
2. **Flexibility**: Allows developers to introduce non-breaking changes without affecting existing clients.

**Cons of REST API Versioning**
1. **Maintenance Overhead**: Maintaining multiple versions of an API can be challenging.
2. **Potential Confusion**: If not documented well, clients might get confused about which version to use.

## Making versioning comprehensive

The same versioning semantics can be applied to all portions of a project.
* Databases: The Sample database would be versioned as SampleDev, SampleV1, etc.
* Assets: Asset directories like `images` can be versioned as `images_dev`, `images_v1`, etc.
* Web document root: The web document can be split into subdirectories like `dev`, `v1`, etc.

The point is that a single system of semantic, incremental versioning is applied across all project features, leading to disciplined, well-defined versioning throughout.

## Composer versioning

Composer has a limitation: it can only support one version of a library at any given time. This can complicate the upgrade process.

On the other hand, PageMaker has a built-in library versioning system. It allows both a development version and several release versions of the PageMaker library to coexist within the same project. This flexibility enables developers to upgrade different parts of the project separately.

## Conclusion

While both internal content versioning for a PHP project and REST API versioning serve the purpose of managing changes over time, their applications are different. The former is more about organizing and managing code and content within a project, while the latter is about ensuring external applications can consistently interact with a service. The choice between them (or the decision to use both) depends on the specific needs of the project and its interaction with external systems.
