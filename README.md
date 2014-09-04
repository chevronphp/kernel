# chevron/kernel

Kernel comprises a router, dispatcher, and response. They are one
package because the parts of an application they represent are all
necessary. While they are distinct, they are all symbiotic. You could
probably use one of these with a component from a different ecosystem
but you'd probably end up doing a bit of gymnastics to glue them
together. That's why I've packaged these components together. Given
that composer makes importing code trivial, you can plug this in and
use part of it or use all of it. In the end, these components make a
lot more sense when placed in context with each other.

At one point this package contianed a controller and a request object.
They remain as their own branch.

Peruse the tests or, if present, the examples directory to see usage.

See [packagist](https://packagist.org/packages/chevron/kernel) for version/installation info. At the moment, I recommend using `"chevron/kernel":"~1.0"`.

[![Latest Stable Version](https://poser.pugx.org/chevron/kernel/v/stable.svg)](https://packagist.org/packages/chevron/kernel)
[![Build Status](https://travis-ci.org/chevronphp/kernel.svg?branch=master)](https://travis-ci.org/chevronphp/kernel)




