# [Reflection](reflect.md) / [ReflectProperty](reflect-ReflectProperty.md) :: __construct
 > im\reflect\ReflectProperty
____

## Synopsis
```php
public __construct(ReflectionClass|string|null $class, ReflectionProperty|string $property)
```

## Parameters
| Name | Description |
| :--- | :---------- |
| class | A `string` containing a full class name or an instance of a PHP `ReflectionClass`.<br />This MUST be a class that contains the constant. If this is `NULL`, then<br />declaring class is used from `$property`. |
| property | A `string` containing the name of the property or an instance of a PHP `ReflectionProperty`. |
