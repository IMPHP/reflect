# [Reflection](reflect.md) / ReflectUnionType
 > im\reflect\ReflectUnionType
____

## Description
An abstraction for the PHP `ReflectionUnionType`.

This class properly extends `ReflectType`, just like
PHP should have done with it's `ReflectionUnionType`
vs `ReflectionNamedType`.

## Synopsis
```php
class ReflectUnionType extends im\reflect\ReflectType implements Stringable {

    // Methods
    public __construct(ReflectionUnionType $type)
    public getTypes(): im\util\IndexArray
    public getName(): string
    public isNative(): bool

    // Inherited Methods
    public isNullable(): bool
}
```

## Methods
| Name | Description |
| :--- | :---------- |
| [__ReflectUnionType&nbsp;::&nbsp;\_\_construct__](reflect-ReflectUnionType-__construct.md) |  |
| [__ReflectUnionType&nbsp;::&nbsp;getTypes__](reflect-ReflectUnionType-getTypes.md) | Get a list of all the types in this union |
| [__ReflectUnionType&nbsp;::&nbsp;getName__](reflect-ReflectUnionType-getName.md) | Get the names of this union type |
| [__ReflectUnionType&nbsp;::&nbsp;isNative__](reflect-ReflectUnionType-isNative.md) | Check to see if all types in the union are builtin PHP types |
| [__ReflectUnionType&nbsp;::&nbsp;isNullable__](reflect-ReflectUnionType-isNullable.md) | Check to see if this type allows `NULL` |
