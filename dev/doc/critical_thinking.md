# Critical Thinking

## What is critical thinking?

Critical thinking is when you understand why and how you should be doing things so you can do the more effectively.

The alternatives to critical thinking are:
* Magical thinking, in which you imagine that technology or methodology solves all of your problems and you simply need to apply all of the right technologies or methodologies to succeed.
* Cargo cult programming, in which you mindlessly imitate technical practices that other people do without understanding their reasoning and context.
* Jumping on the bandwagon, in which you throw out all old technologies and replace them with new ones simply because they are newer.

## How do I practice critical thinking?

Critical thinking begins with understanding your problem and its context. How is your work going to add value to its users and how does your work differ from other people's work? You need to focus on the unique value that you add.

Then you need to consider what technologies or methodologies you need to adopt in order to solve those problems. You should start by asking questions like these:
* Why should I use this technology or methodology? What are its benefits?
* When should I use this technology or methodology? In what context is it applicable?
* When should I not use this technology or methodology? How can I identify when it is being used excessively or in the wrong context?
* How should I use this technology and methodology? What standards or best practices can I adopt to limit my usage to simple techniques that solve my problem?

The alternatives to the asking these questions are:
* Assuming that a technology or methodology is powerful because everyone is talking about it and using it.
* Failing to justify the circumstances in which you should actually use the technology or methodology in your particular context.
* Failing to place limits on a technology or methodology until it grows beyond its usefulness into a an all-purpose solution to everything that ignores more pertinent solutions.
* Failing to specify style and usage guidelines that make your usage of a technology or methodology consistent and productive in your environment.

This happens frequently when large companies conspicuously adopt a technology or methodology. Frequently smaller companies imitate those solutions without asking if they were needed in the first place at their scale or in their context. An example would be the school of thinking that everything should be a REST API. REST APIs are useful in their context for large companies that outgrow their servers and for providers of third-party software that need multi-language programming support. For everyone else, REST APIs decrease scalability and increase complexity and data fragmentation.

So let's try asking some basic questions about it:
* Why should I use a REST API? It lets you break services into more than one host, update web pages without reloading them, and support more than one programming language.
* When should I use a REST API? When a service outgrows its server, when it makes sense to update part of a page rather than reloading it, or when your API needs to support more than one programming language.
* When should I not use a REST API? When all you need is a unit of modularity, when your microservice hasn't outgrown its host, when it's better to reload your whole page, and when you're only using one programming language.
* How should I use a REST API? You should develop consistent naming conventions and guidelines on its use in your particular contact. These guidelines should explicitly consider alternatives and specify when it should be used and when it shouldn't be used.

REST APIs are widely overused. This illustrates the fallacy of thinking that breaking something into parts makes it simpler. Each REST API seems simple in itself. But if their usage has not been justified, they are adding additional layers of complexity, slowness, and indirectness. It would be better critical thinking to consider alternatives that also provide modularity instead of the REST API, such as:
* Separate code projects
* Separate code units such as namespace or classes
* Or for data storage, a separate database table

## What are the limits of critical thinking?

The problem with critical thinking is that it dwells on philosophical generalities, therefore it isn't always the right tool for the job. Critical thinking is only one aspect of good project development. There are other possible viewpoints, such as:
* Good business perspective
* Detailed technical engineering
