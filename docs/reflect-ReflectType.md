# [Reflection](reflect.md) / ReflectType
 > im\reflect\ReflectType
____

## Description
An abstraction for the PHP `ReflectionType`.

## Synopsis
```php
class ReflectType implements Stringable {

    // Methods
    public __construct(ReflectionNamedType $type)
    public getName(): string
    public isNative(): bool
    public isNullable(): bool
}
```

## Methods
| Name | Description |
| :--- | :---------- |
| [__ReflectType&nbsp;::&nbsp;\_\_construct__](reflect-ReflectType-__construct.md) |  |
| [__ReflectType&nbsp;::&nbsp;getName__](reflect-ReflectType-getName.md) | Det the name of the type |
| [__ReflectType&nbsp;::&nbsp;isNative__](reflect-ReflectType-isNative.md) | Check to see if this type is a builtin PHP type |
| [__ReflectType&nbsp;::&nbsp;isNullable__](reflect-ReflectType-isNullable.md) | Check to see if this type allows `NULL` |
