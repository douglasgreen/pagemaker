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
