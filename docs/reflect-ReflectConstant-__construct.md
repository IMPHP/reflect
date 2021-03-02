# [Reflection](reflect.md) / [ReflectConstant](reflect-ReflectConstant.md) :: __construct
 > im\reflect\ReflectConstant
____

## Synopsis
```php
public __construct(ReflectionClass|string|null $class, ReflectionClassConstant|string $property)
```

## Parameters
| Name | Description |
| :--- | :---------- |
| class | A `string` containing a full class name or an instance of a PHP `ReflectionClass`.<br />This MUST be a class that contains the property. If this is `NULL`, then<br />declaring class is used from `$property`. |
| property | A `string` containing the name of the constant or an instance of a PHP `ReflectionClassConstant`. |
