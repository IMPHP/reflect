# [Reflection](reflect.md) / ReflectConstant
 > im\reflect\ReflectConstant
____

## Description
An abstraction for the PHP `ReflectionClassConstant`.

## Synopsis
```php
class ReflectConstant extends im\reflect\ReflectMember implements Stringable {

    // Inherited Constants
    public M_PUBLIC = 1
    public M_PROTECTED = 2
    public M_PRIVATE = 4

    // Methods
    public __construct(ReflectionClass|string|null $class, ReflectionClassConstant|string $property)
    public getDeclaringClass(): im\reflect\ReflectClass
    public getOverrideClass(): null|im\reflect\ReflectClass
    public getValue(): mixed
    public getName(): string
    public getDocComment(): null|string
    public getModifiers(): int

    // Inherited Methods
    public getModifierNames(): null|string
    public isPublic(): bool
    public isPrivate(): bool
    public isProtected(): bool
    public isInherited(): bool
    public getClass(): im\reflect\ReflectClass
}
```

## Constants
| Name | Description |
| :--- | :---------- |
| [__ReflectConstant&nbsp;::&nbsp;M\_PUBLIC__](reflect-ReflectConstant-prop_M_PUBLIC.md) |  |
| [__ReflectConstant&nbsp;::&nbsp;M\_PROTECTED__](reflect-ReflectConstant-prop_M_PROTECTED.md) |  |
| [__ReflectConstant&nbsp;::&nbsp;M\_PRIVATE__](reflect-ReflectConstant-prop_M_PRIVATE.md) |  |

## Methods
| Name | Description |
| :--- | :---------- |
| [__ReflectConstant&nbsp;::&nbsp;\_\_construct__](reflect-ReflectConstant-__construct.md) |  |
| [__ReflectConstant&nbsp;::&nbsp;getDeclaringClass__](reflect-ReflectConstant-getDeclaringClass.md) | Get the class that declared this member |
| [__ReflectConstant&nbsp;::&nbsp;getOverrideClass__](reflect-ReflectConstant-getOverrideClass.md) | Get the class that this member is overriding |
| [__ReflectConstant&nbsp;::&nbsp;getValue__](reflect-ReflectConstant-getValue.md) | Get the value from this constant |
| [__ReflectConstant&nbsp;::&nbsp;getName__](reflect-ReflectConstant-getName.md) | Get the name of this member |
| [__ReflectConstant&nbsp;::&nbsp;getDocComment__](reflect-ReflectConstant-getDocComment.md) | Get the DocComment from this member |
| [__ReflectConstant&nbsp;::&nbsp;getModifiers__](reflect-ReflectConstant-getModifiers.md) | Get the modifier flags for this member |
| [__ReflectConstant&nbsp;::&nbsp;getModifierNames__](reflect-ReflectConstant-getModifierNames.md) | Get the string representation of the modifiers |
| [__ReflectConstant&nbsp;::&nbsp;isPublic__](reflect-ReflectConstant-isPublic.md) | Check to see if this member is `public` |
| [__ReflectConstant&nbsp;::&nbsp;isPrivate__](reflect-ReflectConstant-isPrivate.md) | Check to see if this member is `private` |
| [__ReflectConstant&nbsp;::&nbsp;isProtected__](reflect-ReflectConstant-isProtected.md) | Check to see if this member is `protected` |
| [__ReflectConstant&nbsp;::&nbsp;isInherited__](reflect-ReflectConstant-isInherited.md) | Check to see if this is an inherited method of the current class |
| [__ReflectConstant&nbsp;::&nbsp;getClass__](reflect-ReflectConstant-getClass.md) | Get the current class that this member belongs to |
