# [Reflection](reflect.md) / [ReflectMethod](reflect-ReflectMethod.md) :: getDeclaringClass
 > im\reflect\ReflectMethod
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
