# [Reflection](reflect.md) / [ReflectMethod](reflect-ReflectMethod.md) :: invoke
 > im\reflect\ReflectMethod
____

## Description
Invoke this method

## Synopsis
```php
public invoke(null|object $instance = NULL, mixed ...$args): mixed
```

## Parameters
| Name | Description |
| :--- | :---------- |
| instance | An object to use if this is not a static method |
| args | Arguments to pass to the method |

## Return
Returns the result from the method.
If the method is a `void`, no value is returned.
