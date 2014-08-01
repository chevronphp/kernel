# chevron.kernel

Kernel comprises a router, dispatcher, and controller. With a little work they
could probably be independent pieces but if you want to use one you'll have to
supply the other components (even if you're not using these). To eliminate
confusion (and because I coupled these peices together) they coexist in one
package.

These components would benefit from beig decoupled. However, the represent the various
pieces of a working application and while they are distinct, they are all symbiotic.
You could probably use one of these with a component from a different ecosystem but
you'd probably end up doing a bit of gymnastics to glue tem together. That's why
I've packaged these components together. Given that composer makes importing code
trivial, you can plug this in and use part of it or use all of it. In the end,
these components make a lot more sense when placed in context with each other.

# Usage

See examples/ or tests/ ...

# Installation

Using [Composer](http://getcomposer.org/) `"require" : { "henderjon/chevron-kernel": "~1.0" }`

# license

See LICENSE.md for the [BSD-3-Clause](http://opensource.org/licenses/BSD-3-Clause) license.

## links

  - The [Packagist archive](https://packagist.org/packages/henderjon/chevron-kernel)
  - Reading on [Semantic Versioning](http://semver.org/)
  - Reading on [Composer Versioning](https://getcomposer.org/doc/01-basic-usage.md#package-versions)

### cool kids badges

#### travis

[![Build Status](https://travis-ci.org/henderjon/chevron.kernel.svg?branch=master)](https://travis-ci.org/henderjon/chevron.kernel)

#### scruitinizer

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/henderjon/chevron.kernel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/henderjon/chevron.kernel/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/henderjon/chevron.kernel/badges/build.png?b=master)](https://scrutinizer-ci.com/g/henderjon/chevron.kernel/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/henderjon/chevron.kernel/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/henderjon/chevron.kernel/?branch=master)




