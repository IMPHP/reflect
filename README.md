# IMPHP - Reflection
___

This package provides an abstraction for PHP's reflection API. The current implementation of PHP's Reflection API is extremely old and patched to such a degree, that it needs a complete overhaul. It does not get better by the fact that it already seams to have gotten very little attention during the years, and the little attention it has had, has been more or less a rush job. The latest in PHP 8.0 even breaks backward compatibility with it's new `ReflectionUnionType`.

This package provides new tools for reflection, but still tries to keep it more or less the same.

### __OOP__

Functions vs. classes is a debate that will never end. Some likes one thing, some likes another and a third likes to mix it. The policy of IMPHP is that functions in PHP is good for one thing, and that is as simple callables for parameter usage. This reflection package provides all the tools you need to extract information about a class, class members, method parameters and such. It does not provide any tools for single functions or global variables/constants.

### Full Documentation

You can view the [Full Documentation](docs/reflect.md) to lean more about what this offers.

### Installation

__Clone via git__

```sh
git clone https://github.com/IMPHP/base.git imphp/reflect/
```

__Composer _(Packagist)___

```sh
composer require imphp/reflect
```
