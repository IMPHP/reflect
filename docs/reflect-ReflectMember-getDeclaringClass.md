# [Reflection](reflect.md) / [ReflectMember](reflect-ReflectMember.md) :: getDeclaringClass
 > im\reflect\ReflectMember
____

## Description
Get the class that declared this member.

If this is an inherited member, then this will return the clostest
parent class that declares this member. If the current class is
declaring class, then `getDeclaringClass() == getClass()`.

## Synopsis
```php
abstract public getDeclaringClass(): im\reflect\ReflectClass
```
