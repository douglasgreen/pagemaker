# REST APIs

## Usage

REST APIs should be added last to the top layer for in-page animations. The system should work without them.

## Internal endpoints

API endpoints can be a subdirectory of the current project and don't have to be a separate project. They can reuse the current database connection and HTTP host.

## Scalability

REST APIs are often described as scalable. But their scalability should be broken down into two senses:
* Throughput, meaning they scale because you dedicated a separate server to them.
* Latency, meaning they don't scale because each response is transferred across the network.

When REST APIs fragment into microservices, the latency starts to dominate.

## What are the costs and benefits of REST API modularity versus code or project modularity?

I'll use PHP as an example. Consider three basic alternatives:
1. Break your code down into classes and load them with an auto loader.
2. Do the same as number one but load your code in a separate project using Composer.
3. Do the same as number two but split your project into a separate microservice using a REST API.

Case 1 is the fastest and most direct. The benefit is that your API is a PHP API, which consists of lightweight, typed function calls. These calls execute directly on the local host and are the fastest and most feature-rich interface.

Case 2 has all of the same qualities as number one except the code is separated into a different repository and installed using Composer. The only difficulty there is now you have to push changes to both repositories every time you make a release to the new repository. However, splitting it into a separate repository allows you to more rigorously separate it from the main repository.

Case 3 is similar to the other cases except now we split your project into a REST API.

The benefits are:
* Your code is walled off behind a REST API so it is very isolated and can't talk directly to the local code base. Being isolated makes it seem easier to understand. However, note that your project is actually not any more modular than before so it should have been easy to understand even as modular code or a separate project.
* Your code can now run on a different host, if your current host is out of resources. However, note that your database code could have always run on a different host even without a REST API.
* Your code can now be called using more than one language, if you require that. This is mainly useful for providers of public third-party services. For in-house development, a single language like PHP could be stipulated.

The costs are:
* Your code and your database are probably split from the main database. This creates a state of data fragmentation where your foreign keys can't be enforced or easily looked up.
* Your code requires extra steps of setup and authentication.
* Your REST API is untyped and feature-poor compared to direct access through PHP.
* The slowness of the REST API and its extra layers is compounded by the slowness of delivery across a network. The network introduces additional network problems and complexity.

Things that haven't really changed are:
* The ability to version, because you could have always versioned your local code or the Composer project.
* Modularity, because you don't have to enforce network isolation to have modularity.

So when should REST APIs be used? When their costs are outweighed by their benefits with respect to requirements such as:
* Scaling beyond a single server, but this might also be done by splitting up the database without splitting up the code.
* Using multiple programming languages, but this might also be done by creating a shared data format rather than a shared service format.
* Reloading part of the page, but this might also be done by reloading the whole page.

For small single-party projects, the last usage is the most common. These projects required neither the scalability of major projects nor the generality of a third-party API.

A REST API meets the requirement of reloading part of the page. And it is efficient because the REST API request substitutes for a page load, which would require a trip across the network anyway. Efficiency would require a minimum number of REST API requests per user interaction. And so the most efficient use of REST APIs for small projects would be to implement top-level interactive user features in a one-to-one fashion, where one user action results in one API request.

REST APIs should also be built on a fast lower layer of direct programming language APIs. These APIs should be used when more direct speedy access is required.
