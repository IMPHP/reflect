# [Reflection](reflect.md) / [ReflectMethod](reflect-ReflectMethod.md) :: __construct
 > im\reflect\ReflectMethod
____

## Synopsis
```php
public __construct(ReflectionClass|string|null $class, ReflectionMethod|string $method)
```

## Parameters
| Name | Description |
| :--- | :---------- |
| class | A `string` containing a full class name or an instance of a PHP `ReflectionClass`.<br />This MUST be a class that contains the method. If this is `NULL`, then<br />declaring class is used from `$method`. |
| method | A `string` containing the name of the method or an instance of a PHP `ReflectionMethod`. |
