# [Reflection](reflect.md) / [ReflectMethod](reflect-ReflectMethod.md) :: isInherited
 > im\reflect\ReflectMethod
____

## Description
Check to see if this is an inherited method of the current class.

## Synopsis
```php
public isInherited(): bool
```

## Return
This returns `TRUE` when `$this->getClass()` does NOT equal `$this->getDeclaringClass()`
