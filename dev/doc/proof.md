# Proof in Computer Programming

Proof is often used in mathematics. It can be defined generally as sound reasoning over an entire problem domain. Therefore proof is deductive reasoning, where the programmer reasons from the entire problem domain to specific examples.

The opposite of proof is inductive reasoning, which is reasoning from particular examples to general conclusions. Unit testing is a form of inductive reasoning which attempts to show that your program is correct by proving that particular examples of it are correct.

##  When should proof be used

In math, a problem domain is frequently the entire set of integers or real numbers. This can also be true in programming but the domain of programming is always finite and limited by storage space.

More frequently in programming we are reasoning over a particular set of data or data structures. Such reasoning is considered proof when the entire domain of such data structures is considered. This usually requires reasoning at a higher level description of the problem rather than focusing on particular examples.

## When should prove not be used

In example of an unproven conjecture in mathematics as the Collatz conjecture. It states that if you divide a number by 2 when it is even or multiplied by 3 and add 1 when it is odd, then you will eventually reach one by repeated application of these steps. The problem with the Collatz conjecture is that it is a finite process whose conditions change with each step. This makes it hard to describe at a higher level and therefore hard to solved.

Programming is often like that also. It's dynamic, finite, and process-oriented. As such, it is often difficult to reason over the entire domain of programming problems. The programmer is tempted to reason from specific instances using the computer as a tool. However the lack of proof leaves your program subject to various errors when your problem domain was not fully or correctly covered.

So the programmer should be reminded that proof is available as a problem-solving tool. Proof should be considered when it seems relevant and feasible.
