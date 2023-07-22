# Object-oriented programming

## Interfaces

### What sort of methods should interfaces define?

Interfaces should use minimal arguments for flexibility and focus on the outputs that they produce.

They should prefer methods that provide service like render() instead of getters that turn the object into a bag of data.

The should avoid specifying setters so that either setters or a constructor can build the data more flexibly.

Setters can be provided on the abstract class that implements the interface.

### Why do interfaces go into the Contracts namespace?

Interfaces should be general constructs, not just restatement of whatever a class happens to do. Putting them in the contracts directory also helps name them more concisely. Instead of a RequestInterface in the Request directory, there is just a simple Request interface in the contracts directory. The interface is used differently than the implementation so there is no confusion. The implementation is used when the concrete instance is created and the interface is used when it is injected as a dependency in another place where a class is defined. These are two different usages so both of them are named Request.
* PageMaker\Contracts\Request - the interface
* PageMaker\Request - the implementation

## Abstract classes



## Access modifiers

### Why shouldn't I use private members?

Access modifiers determine the visibility and accessibility of class members. By using `protected` or `public` access modifiers, a class ensures that its members can be overridden by subclasses. This provides flexibility and allows for the extension of class functionality without modifying the original class.

## Methods

### How should I break down methods in a class?

When functions are monolithic or too large, they become difficult to override or extend. By breaking functions into smaller, more modular pieces, subclasses can selectively override specific parts of a function without having to rewrite the entire function. This modular approach promotes code reusability and maintainability.

### Why shouldn't I use mutable static properties?

Mutable static properties can introduce unexpected behaviors in a program, especially when multiple instances of a class are involved. By ensuring that static properties are immutable, a class can maintain consistent behavior across all instances. This reduces the risk of side effects and makes the class more predictable.

### Why shouldn't I store objects in a PHP session?

Storing objects in sessions can lead to potential issues. For instance, serialized objects might become outdated if the class definition changes, leading to deserialization errors. Moreover, storing large objects in sessions can consume significant memory. A well-behaved class avoids session storage, ensuring that instances are created and managed appropriately without relying on session persistence.






### Striking a balance between specific type-checking of inputs and allowing flexibility in inputs

While it's essential to ensure that inputs to a function or method are of the expected type, being overly strict can limit flexibility. A well-behaved class finds a balance by implementing specific type-checking where necessary but also allowing for flexible inputs where appropriate. This ensures that the class remains robust while also being adaptable to different use cases.

### Ensuring ease of setup for the class

A class should be designed in a way that makes it easy to instantiate and use. This includes providing clear documentation, intuitive constructors, and default values where necessary. An easy-to-setup class reduces the learning curve for developers and promotes its adoption in various projects.

## Interfaces vs. abstact classes

Interfaces let the user define their own data as well as their own functionality. So interfaces are more extensible
than abstract classes.

Interfaces should not define constructors because those also define implementation specific data details.

Abstract classes are used instead of concrete classes when the implementation is by definition general and incomplete. When a complete definition can be given, it is preferred to use a concrete class directly.

An example of an abstract class is the Widget class, because it sets up a widget typical data without defining any behavior.

An example of concrete class is the email sender class, because it's always possible to send email due to Its predefined behavior.

Optional values of function arguments are left out of the interface definitions.

## Interface docs

Document argument and return types on the interface so they are implemented consistently in implementations. This should also include where they're an exception is expected to be thrown.

The proper way to express that an implementation does exactly like the interface is to omit the docblock. Don't use inherentDoc to mean that it should inherit the docblock of the interface because it's actually just to insert the long description not the entire dock block.

Leave any optional arguments off of an interface declaration.

## Interface implementation

The implementation of an interface should not expose any more public methods than are defined in the interface. If a caller depends on optional public methods, then the interface is not compatible. The constructor is an exception because it is called at the time the class is instantiated not when it is passed around and used.

The interface can be aliases to use both at once:

use PageMaker\Contract\Registry as RegistryInterface;

## Class names

Don't add noise words like Manager or Handler at the end of class names. All classes manage and handle data. It's part of the definition of class.

PSR rules are used for abstract class names, where <name> is the class name.
* Abstract<name>

However, Interfaces are put into the Contracts directory and not named <name>Interface.

## Single responsibility principle

Don't mix I/O, processing, and storage in the same class?

## Static calls

Use registry instead of static calls so classes can be replaced at runtime. However it's OK to provide static utility classes. The classes that use them can be overridden if needed.

## File order

The members come in this order:
* properties
* methods

The top groups come in this order:
* const
* static
* instance

The access levels come in this order:
* public
* protected

The members come in this order:
* logical reference
* alphabetical

For example, the methods come in this logical order:
* magic methods/constructor/destructor
* setters
* getters
* finalizers like render, save, etc.

Getters and setters should be symmetrical by default, that is, each getter should have a setter and vice versa.

## Controllers

Controllers are defined by the router as <page>Controller with method get<action> or post<action>.
