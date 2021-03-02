# [Reflection](reflect.md) / [ReflectParameter](reflect-ReflectParameter.md) :: getDefaultValue
 > im\reflect\ReflectParameter
____

## Description
Get the default value that this parameter was defined with.

## Synopsis
```php
public getDefaultValue(): mixed
```

## Return
This method will return `NULL` if the parameter has no default value.
Note though that the parameter itself may be defined with `NULL` as it's
default value. Use `hasDefaultValue()` to see if the parameter actually
has a default value.
