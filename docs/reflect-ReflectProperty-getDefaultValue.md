# [Reflection](reflect.md) / [ReflectProperty](reflect-ReflectProperty.md) :: getDefaultValue
 > im\reflect\ReflectProperty
____

## Description
Get the default value from this property.

## Synopsis
```php
public getDefaultValue(): mixed
```

## Return
This method will return `NULL` if the property does not
have a default value. However the property itself may also
be initialized with a default value of `NULL`.
Use `hasDefaultValue()` if you want to know if the property
does in fact have a default value or not.
