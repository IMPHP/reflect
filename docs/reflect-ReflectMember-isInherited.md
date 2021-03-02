# [Reflection](reflect.md) / [ReflectMember](reflect-ReflectMember.md) :: isInherited
 > im\reflect\ReflectMember
____

## Description
Check to see if this is an inherited method of the current class.

## Synopsis
```php
public isInherited(): bool
```

## Return
This returns `TRUE` when `$this->getClass()` does NOT equal `$this->getDeclaringClass()`
