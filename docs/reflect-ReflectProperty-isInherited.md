# [Reflection](reflect.md) / [ReflectProperty](reflect-ReflectProperty.md) :: isInherited
 > im\reflect\ReflectProperty
____

## Description
Check to see if this is an inherited method of the current class.

## Synopsis
```php
public isInherited(): bool
```

## Return
This returns `TRUE` when `$this->getClass()` does NOT equal `$this->getDeclaringClass()`
