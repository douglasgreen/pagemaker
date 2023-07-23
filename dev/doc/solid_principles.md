# SOLID principles

## What are the SOLID principles?

The solid principles are five principles of programming that form a convenient acronym:
* S - Single-Responsiblity Principle (SRP)
* O - Open-Closed Principle (OCP)
* L - Liskov Substitution Principle (LSP)
* I - Interface Segregation Principle (ISP)
* D - Dependency Inversion Principle (DIP)

I think the SOLID principles are overrated. Even worse, they tell you little about good design principles that are actually required.

## Single-Responsiblity Principle (SRP)

The SRP states that:
> A class should have one and only one reason to change, meaning that a class should have only one job.

I think this advice is poorly expressed. In the days before effective version control, having only one reason to change would prevent conflicts because only one person was changing a file at a time. This is not an important principle in the age of effective version control. It also doesn't provide good guidance because having only one reason to change is nebulous and undefined.

However, SRP is still a good principle. Each class should serve a single purpose and that purpose should be reflected in its name. This is a principle of good organization and description that makes your system easy to describe and easy to understand. Another term for that is to say that a class should have high cohesion, meaning that its parts belong together.

I would further amend the principle to state that the one purpose of a class should be defined in terms of unit testing. That is, its responsibilities should be defined consistent with unit testing. For this reason, you should split things that are easy to unit test like application logic and domain calculations from other concerns like input, output, and storage which are harder to test.

So I would restate the principle as follows:
> A class should have a single purpose consistent with its name and should have separate methods that are consistent with unit testing.

## Open-Closed Principle (OCP)

The OCP states that:
> Objects or entities should be open for extension but closed for modification.

This is an obsolete principle that is still trying to be relevant. It also refers to the days before version control when classes were hard to modify. It is also poorly stated in a way that makes little sense. How can a class be open or closed?

Modifying a class is often the preferred solution rather than maintaining multiple layers of changes without integrating them. So we shouldn't reject class modification because of this principle. Unfortunately the principle is dated as an absolute as though it were bad to modify code, which in many cases it is not.

So I would restate the principle as follows:
> A class should be designed in a way that is easy to extend or customize when possible, but modified directly when necessary.

This design goal is accomplished through some combination of interfaces, inheritance, and composition.

## Liskov Substitution Principle (LSP)

The OCP states that:
> Let q(x) be a property provable about objects of x of type T. Then q(y) should be provable for objects y of type S where S is a subtype of T.

Another word for subtype is a subclass that inherits from a superclass. This principle makes sense because if child classes behaved differently than their superclass, they would cause errors when they were substituted, which would ruin polymorphism.

So I would restate the principle as follows:
> A subclass should be designed in a compatible way with the superclass so that it can be substituted for it.

## Interface Segregation Principle

The ISP states that:
> A client should never be forced to implement an interface that it doesn’t use, or clients shouldn’t be forced to depend on methods they do not use.

This is also a weak principle that has little to do with programming. In programming, interfaces are arbitrary structures that are usually defined around a single purpose. And no client is forced to implement them.

This principle makes more sense if you consider it a principle of user interface design. It means that you should consider different types of users of your system and how they view and use it when you design your interface.

So I would restate the principle as follows:
> An interface should be designed with a minimal and complete set of methods that a caller would depend on, so that any object that meets the interface can substitute for any other such object.

Like the LSP, the ISP is concerned with the substitution of code for other code works without errors. In the LSP, a sublass should be able to be substituted for a superclass. In the ISP, all of the implementers of an interface should be able to be substituted for each other.

If someone violates the principle as originally stated, the only harm is that the person defining an implementation has to implement functions that they don't want to. However, if someone violates the principle as I stated it, the result is errors and broken code.

## Dependency Inversion Principle (DIP)

The DIP states that:
> Entities must depend on abstractions, not on concretions. It states that the high-level module must not depend on the low-level module, but they should depend on abstractions.

This principle is only important if you need to switch out concrete implementations. However it is poorly expressed as though this principle were an absolute that must always be followed, which is not the case. There is no absolute in programming that one must always use more interfaces, abstract classes, or abstractions. Like everything else in programming, they should only be used when they are required. There is no such thing as perfect abstraction and every other layer of abstraction and interaction has a cost.

So I would restate the principle as follows:
> Provide abstraction or indirection instead of concreteness and directness only when required for a flexible, substitutable design. 

Providing abstractions or indirection when you don't need them is a violation of another principle called [you aren't gonna need it (YAGNI)](https://en.wikipedia.org/wiki/You_aren%27t_gonna_need_it). It is needless and directness and useless complexity.

