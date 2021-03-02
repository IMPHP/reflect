# [Reflection](reflect.md) / [ReflectClass](reflect-ReflectClass.md) :: invoke
 > im\reflect\ReflectClass
____

## Description
Invoke the class constructor to get an instance object of this class.

This object can also be used in other reflection classes
such as `ReflectMethod`, `ReflectConstant` and `ReflectProperty` to
interact with the object through this reflection library.

 > Unlike the PHP `ReflectionClass::newInstance()`, this method can access any constructor regardless of whether it is a `private` or `protected` constructor, even if they are inherited or non-existing.  

## Synopsis
```php
public invoke(mixed ...$args): object
```

## Parameters
| Name | Description |
| :--- | :---------- |
| args | Arguments to pass to the constructor |
