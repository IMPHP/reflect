# [Reflection](reflect.md) / ReflectParameter
 > im\reflect\ReflectParameter
____

## Description
An abstraction for the PHP `ReflectionParameter`.

## Synopsis
```php
class ReflectParameter implements Stringable {

    // Methods
    public __construct(ReflectionMethod|string|null $method, ReflectionParameter|string|int $param)
    public getMethod(): im\reflect\ReflectMethod
    public getName(): string
    public getPosition(): int
    public isNullable(): bool
    public isOptional(): bool
    public isByRef(): bool
    public isVariadic(): bool
    public hasType(): bool
    public getType(): null|im\reflect\ReflectType
    public hasDefaultValue(): bool
    public getDefaultValue(): mixed
}
```

## Methods
| Name | Description |
| :--- | :---------- |
| [__ReflectParameter&nbsp;::&nbsp;\_\_construct__](reflect-ReflectParameter-__construct.md) |  |
| [__ReflectParameter&nbsp;::&nbsp;getMethod__](reflect-ReflectParameter-getMethod.md) | Get the method that this parameter belongs to |
| [__ReflectParameter&nbsp;::&nbsp;getName__](reflect-ReflectParameter-getName.md) | Get the name of this parameter |
| [__ReflectParameter&nbsp;::&nbsp;getPosition__](reflect-ReflectParameter-getPosition.md) | Get the position of this parameter |
| [__ReflectParameter&nbsp;::&nbsp;isNullable__](reflect-ReflectParameter-isNullable.md) | Check to see if this parameter allows `NULL` to be passed |
| [__ReflectParameter&nbsp;::&nbsp;isOptional__](reflect-ReflectParameter-isOptional.md) | Check to see if this parameter is optional |
| [__ReflectParameter&nbsp;::&nbsp;isByRef__](reflect-ReflectParameter-isByRef.md) | Check to see if this parameter is passed by reference |
| [__ReflectParameter&nbsp;::&nbsp;isVariadic__](reflect-ReflectParameter-isVariadic.md) | Check to see if this parameter is variadic |
| [__ReflectParameter&nbsp;::&nbsp;hasType__](reflect-ReflectParameter-hasType.md) | Check to see if this parameter has a type defined |
| [__ReflectParameter&nbsp;::&nbsp;getType__](reflect-ReflectParameter-getType.md) | Get the type that this parameter is defined with |
| [__ReflectParameter&nbsp;::&nbsp;hasDefaultValue__](reflect-ReflectParameter-hasDefaultValue.md) | Check to see if this parameter was defined with a default value |
| [__ReflectParameter&nbsp;::&nbsp;getDefaultValue__](reflect-ReflectParameter-getDefaultValue.md) | Get the default value that this parameter was defined with |
