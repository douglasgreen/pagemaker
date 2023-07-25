# Interfaces Documentation

## Overview of interfaces

Interfaces establish a contract between classes, ensuring that certain methods are implemented. They enhance code flexibility and play a crucial role in dependency injection.

## Purpose of an interface

1. **Flexibility:** An interface allows objects of different classes to be treated uniformly, facilitating polymorphism.
2. **Dependency Injection:** It enables injecting specific implementations into classes, promoting code modularity and testability.

## Methods in interfaces

1. **Inclusion:** All methods or method arguments that a caller may use should be part of the interface. Omitting these would lead to errors.
2. **Focus on Outputs:** Emphasize the results or services an interface provides rather than the inputs.
3. **Service Methods:** Prefer methods like `render()` over getters that merely fetch data. Avoid specifying setters; the implementing class can determine how to set data.
4. **Consistency:** Document argument and return types to ensure uniform implementation across classes. Highlight expected exceptions.
5. **No Optional Arguments:** Exclude optional method arguments from interface declarations.

## Organization and naming

1. **Location:** Interfaces are placed in the `Contract` namespace, emphasizing their role as generalized contracts, not tied to specific class implementations.
2. **Naming Convention:** 
   - Interface: `PageMaker\Contract\Request`
   - Implementation: `PageMaker\Request`

## Interfaces vs. abstract classes

1. **Interfaces:** Provide method signatures without imposing any structure or behavior, allowing complete extensibility.
2. **Abstract Classes:** Offer a blend of predefined (yet potentially incomplete) behavior and unimplemented methods. Examples include a general `Widget` class.

## Implementing an interface

1. **Consistency:** The implementing class should not have extra public methods beyond what the interface defines, except for the constructor.
2. **Aliasing:** To use an interface and its implementation concurrently, alias them, e.g., `use PageMaker\Contract\Registry as RegistryInterface`.

# Class design principles

## Access modifiers

1. **Flexibility:** Use `protected` or `public` to ensure class members can be extended by subclasses. Avoid private members which can't be overridden.
   
## Method organization

1. **Modularity:** Decompose large functions into smaller, more manageable pieces to enhance extensibility.
2. **Type-Checking:** Balance strict type-checking with input flexibility. 
3. **Setup:** Ensure classes are easy to set up, well-documented, and intuitive.

## Class naming

1. **Simplicity:** Avoid redundant words like "Manager" or "Handler."
2. **PSR Naming:** For abstract classes, use the format: `Abstract<name>`. Interfaces don't require the "Interface" suffix and belong in the `Contract` directory.

## Design principles

1. **Single Responsibility:** Each class should have a single responsibility. Separate I/O, processing, and storage.
2. **Static Calls:** Avoid static calls. Use registries to enable class replacements at runtime. Static utility classes are exceptions.
3. **File Structure:** 
   - Group by: const > static > instance.
   - Order by access level: public > protected.
   - Logical order: magic methods > setters > getters > finalizers.

## Controllers

Controllers are identified by routers using the pattern: `<page>Controller` with methods formatted as `get<action>` or `post<action>`.

<!-- DSG/ChatGPT 7/25/2023 -->
