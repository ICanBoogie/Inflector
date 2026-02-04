# CHANGELOG

## v4.0.0

### New requirements

Require PHP 7.4+ (older Debian distributions are now archived)

### New features

None

### Backward Incompatible Changes

None

### Deprecated Features

None

### Other Changes

Updated PHPUnit to v9.6 to avoid [vulnerability](https://github.com/ICanBoogie/Inflector/security/dependabot/1).



## v3.0.2

### New requirements

None

### New features

None

### Backward Incompatible Changes

None

### Deprecated Features

None

### Other Changes

Add invariable French nouns.



## v3.0.1

### New requirements

None

### New features

None

### Backward Incompatible Changes

None

### Deprecated Features

None

### Other Changes

Fix: Helpers are used, although they are no longer required by default. @donatj



## v3.0

### New requirements

None

### New features

Added `StaticInflector`, that can be used instead of the helper functions.

### Backward Incompatible Changes

The file with the helper functions is no longer included in the autoload. You need to include the
file `vendor/icanboogie/inflector/lib/helpers.php` in your `composer.json` if you want to continue
using these functions. Better use the new `StaticInflector` instead.

### Deprecated Features

None

### Other Changes

None



## v2.0

### New requirements

- PHP 7.1+

### New features

None

### Backward Incompatible Changes

None

### Deprecated Features

None

### Other Changes

None
