# Web-Last Architecture

Most architecture puts the web first nowadays. I recommend an architecture that puts the web last. That means that your program should fully work without needing to be passed across the network. The first layer of design should be a complete command-line application. The command should be able to do all basic program functionality. This allows your program to be scripted by writing scripts with series of commands. And it allows for more full automated testing.

The reasons why the web should be put last are:
* It is designed for simple commands that time out.
* An HTML page can't accept more than a limited number of data inputs.
* The PHP session inappropriately serializes data and creates long-term state.
* JavaScript turns your app into a single-page app with needlessly maintained long-term state.
* JavaScript tries to build functionality on an already rendered HTML document layer.
* CSS is poorly designed and not modular so it does not allow for a well-designed style later and third-party style sharing.
* REST APIs fragment your data and needlessly transport it across the network resulting in bottlenecks, delays, and unreliability.
* The full stack pulls in a large amount of needless dependencies resulting in complexity, bloat, and constant upgrades.

In contrast, the command line:
* Doesn't time out so you can process large amounts of data.
* Accepts an unlimited number of data inputs.
* Doesn't maintain a session between requests.
* Doesn't use single-page app architecture.
* Doesn't try to build on an already-rendered document layer. 
* Focuses on data processing rather than on style rendering.
* Doesn't needlessly introduce extra network layers.
* Doesn't require large amount of bloated web dependencies.

The model and controllers should therefore be a command-line only. Then you can build the web layer last when everything is finished.
