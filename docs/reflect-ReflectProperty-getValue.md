# [Reflection](reflect.md) / [ReflectProperty](reflect-ReflectProperty.md) :: getValue
 > im\reflect\ReflectProperty
____

## Description
Get the current value of this property.

## Synopsis
```php
public getValue(null|object $instance = NULL): mixed
```

## Parameters
| Name | Description |
| :--- | :---------- |
| instance | An object to use if this is not a static property |

## Return
This will return `NULL` if the property has not yet been
initialized in any way.
