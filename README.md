# chevron.kernel

Kernel comprises a router, dispatcher, and controller. With a little work they
could probably be independent pieces but if you want to use one you'll have to
supply the other components (even if you're not using these). To eliminate
confusion (and because I coupled these peices together) they coexist in one
package.

These components would benefit from being decoupled. However, they represent the various
pieces of a working application and while they are distinct, they are all symbiotic.
You could probably use one of these with a component from a different ecosystem but
you'd probably end up doing a bit of gymnastics to glue them together. That's why
I've packaged these components together. Given that composer makes importing code
trivial, you can plug this in and use part of it or use all of it. In the end,
these components make a lot more sense when placed in context with each other.

Peruse the tests or, if present, the examples directory to see usage.

See [packagist](https://packagist.org/packages/henderjon/chevron-kernel) for version/installation info. At the moment, I recommend using `~1.0`.

[![Latest Stable Version](https://poser.pugx.org/henderjon/chevron-kernel/v/stable.svg)](https://packagist.org/packages/henderjon/chevron-kernel)
[![Build Status](https://travis-ci.org/henderjon/chevron.kernel.svg?branch=master)](https://travis-ci.org/henderjon/chevron.kernel)




