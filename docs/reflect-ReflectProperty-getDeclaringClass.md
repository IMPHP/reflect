# [Reflection](reflect.md) / [ReflectProperty](reflect-ReflectProperty.md) :: getDeclaringClass
 > im\reflect\ReflectProperty
____

## Description
Get the class that declared this member.

If this is an inherited member, then this will return the clostest
parent class that declares this member. If the current class is
declaring class, then `getDeclaringClass() == getClass()`.

## Synopsis
```php
public getDeclaringClass(): im\reflect\ReflectClass
```
