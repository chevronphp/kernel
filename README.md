# chevron/kernel

So Kernel is still unstable and as much as I would like to tag a v1, I'm going
to wait--not sure how long. However, I've made some I'm-not-going-to-code-that
decisions that deserve an explanation.

For starters, the original idea is to have a handful of (decoupled) components
that when combined, would power a web site. In development, I looked over Aura
and a few other frameworks to see how they did it. In trying to write code that
was a poor man's clone of any one system I wrestled with how I wanted Kernel to
function.

A web app needs a router, dispatcher, controller, and a few other things. The
trick is, decoupling these components makes them just shy of useful without some
elbow grease. I didn't want to be so generic that these pieces would require more
boiler plate. So I went round and round over my controller and landed on
"I'm not going to code one" ...

Basically, your front controller needs to route the request and dispatch it. Adding
a controller might be useful and reduce the boilerplate but means that I'll have to
be more opinionated than I want to be. So I chose to use an interface to define
what a dispatchable class should look like, and then asked my dispatcher to simply
wrap a class (matching the interface) in a closure. It's probably not for everyone
because it still requires a bit of boilerplate but in the end, it's simpler and
in my opinion, more straightforward.

I've left these two pieces decoupled against my better judgment. First, if you're
using Router, you're *probably* using Distacher. Also, Dispatcher accepts a $di in
the constructor. I think it'd be wise to typehint that to Containers\DiInterface.
I also think it'd be wise to typehint the constructor of DispatchableInterface.
But in order to play in the sandbox with the cool kids, I've left them without
opinions.

For historical purposes I've left the old Request and Controller work in a branch
unto themselves.

The `example/` dir has some samples of the boilerplate stuff with a bit more
direction in the comments on how **I** would structure a web app--be it good
or otherwise.

Peruse the tests or, if present, the examples directory to see usage.

See [packagist](https://packagist.org/packages/chevron/kernel) for version/installation info.

[![Latest Stable Version](https://poser.pugx.org/chevron/kernel/v/stable.svg)](https://packagist.org/packages/chevron/kernel)
[![Build Status](https://travis-ci.org/chevronphp/kernel.svg?branch=master)](https://travis-ci.org/chevronphp/kernel)




