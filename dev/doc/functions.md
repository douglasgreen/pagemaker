# Functions

## Why do functions exist?

Functions are a unit of functionality that let you reuse code. They encapsulate the functionality and let you type the parameters. They also replace an opaque block of code with a clear verbal label, the name of the function. Putting your code in a function also enables you to unit test it, increasing code quality.

On the other hand, remember that there is always a cost to calling a function. There is an overhead to pushing its arguments onto the stack and then removing them when the function terminates. In addition, the more functions you write, the more your code is broken apart into little pieces. This forces the reader to jump all over the place to follow the thread of execution.

The alternative to writing a function is to leave your code inline.

## When should I use a function?

You might write a function when:
* The functionality it contains is hard to write, complex, or error prone. Putting it in a function lets you unit test it and reuse it everywhere.
* The function would contain many lines of code or be repeated in many places.
* Writing functions reduces the need to deal with data structures directly, because you can do a function call instead.
* Functions make your code more modular. When the functions are called, you can read a top-level series of descriptive actions rather than the code details.

## When should I not use a function?

You might choose to write your code inline when:
* It can be replaced with a single, simple line of code.
* Your code is simple and does not need to be reused.
* Breaking into a function needlessly separates it from the main line of execution.
* The function is hard to describe and test and does not seem to be a natural unit of execution.
* Using the function does not make your code seem any simpler.

## How should I use functions?

When you define functions:
* Give them the name of an imperative verb. When the function is a method, the implied object of the verb is the class that contains the method. For example `Report::display()` means to display a report.
* Make sure the function does only one thing that matches the name. Function names should not contain "and" or "or" because that implies two different responsibilities.
* Remember that a function name is a label and not a description. It only needs you to remind you of what the function does, not describe every last detail of how it does it. The name just needs to be enough to distinguish the function from other functions within the same context.
* Only make a method public if a user actually needs to call it. So if you need to break up a method, make the inner parts protected instead of public.
* According to Steve McConnell in Code Complete, research indicates that a function should not usually contain more than 200 lines of code. At that point, it becomes harder to understand its internals and it should be broken apart into subfunctions. Of course, you can always break into sub-functions long before it reaches that limit if it makes sense to do so.
