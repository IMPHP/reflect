# [Reflection](reflect.md) / [ReflectParameter](reflect-ReflectParameter.md) :: __construct
 > im\reflect\ReflectParameter
____

## Synopsis
```php
public __construct(ReflectionMethod|string|null $method, ReflectionParameter|string|int $param)
```

## Parameters
| Name | Description |
| :--- | :---------- |
| method | A `string` containing the full name of the method that the parameter belongs to, or<br />an instance of the PHP `ReflectionMethod`. The `string` should be formated as `Class::Method`.<br />If this is `NULL`, then declaring function is used from `$param`. |
| param | An instance of the PHP `ReflectionParameter` or a `string`/`int` defining the parameter<br />name or position. |
