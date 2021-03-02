# [Reflection](reflect.md) / ReflectProperty
 > im\reflect\ReflectProperty
____

## Description
An abstraction for the PHP `ReflectionProperty`.

## Synopsis
```php
class ReflectProperty extends im\reflect\ReflectMember implements Stringable {

    // Constants
    public M_STATIC = 64

    // Inherited Constants
    public M_PUBLIC = 1
    public M_PROTECTED = 2
    public M_PRIVATE = 4

    // Methods
    public __construct(ReflectionClass|string|null $class, ReflectionProperty|string $property)
    public getOverrideClass(): null|im\reflect\ReflectClass
    public getDeclaringClass(): im\reflect\ReflectClass
    public hasDefaultValue(): bool
    public getDefaultValue(): mixed
    public getValue(null|object $instance = NULL): mixed
    public setValue(null|object $instance = NULL, mixed $value): void
    public getName(): string
    public getDocComment(): null|string
    public getModifiers(): int
    public isStatic(): bool
    public hasType(): bool
    public getType(): null|im\reflect\ReflectType

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
| [__ReflectProperty&nbsp;::&nbsp;M\_STATIC__](reflect-ReflectProperty-prop_M_STATIC.md) |  |
| [__ReflectProperty&nbsp;::&nbsp;M\_PUBLIC__](reflect-ReflectProperty-prop_M_PUBLIC.md) |  |
| [__ReflectProperty&nbsp;::&nbsp;M\_PROTECTED__](reflect-ReflectProperty-prop_M_PROTECTED.md) |  |
| [__ReflectProperty&nbsp;::&nbsp;M\_PRIVATE__](reflect-ReflectProperty-prop_M_PRIVATE.md) |  |

## Methods
| Name | Description |
| :--- | :---------- |
| [__ReflectProperty&nbsp;::&nbsp;\_\_construct__](reflect-ReflectProperty-__construct.md) |  |
| [__ReflectProperty&nbsp;::&nbsp;getOverrideClass__](reflect-ReflectProperty-getOverrideClass.md) | Get the class that this member is overriding |
| [__ReflectProperty&nbsp;::&nbsp;getDeclaringClass__](reflect-ReflectProperty-getDeclaringClass.md) | Get the class that declared this member |
| [__ReflectProperty&nbsp;::&nbsp;hasDefaultValue__](reflect-ReflectProperty-hasDefaultValue.md) | Check to see if the property has a default value |
| [__ReflectProperty&nbsp;::&nbsp;getDefaultValue__](reflect-ReflectProperty-getDefaultValue.md) | Get the default value from this property |
| [__ReflectProperty&nbsp;::&nbsp;getValue__](reflect-ReflectProperty-getValue.md) | Get the current value of this property |
| [__ReflectProperty&nbsp;::&nbsp;setValue__](reflect-ReflectProperty-setValue.md) | Change the value on this property |
| [__ReflectProperty&nbsp;::&nbsp;getName__](reflect-ReflectProperty-getName.md) | Get the name of this member |
| [__ReflectProperty&nbsp;::&nbsp;getDocComment__](reflect-ReflectProperty-getDocComment.md) | Get the DocComment from this member |
| [__ReflectProperty&nbsp;::&nbsp;getModifiers__](reflect-ReflectProperty-getModifiers.md) | Get the modifier flags for this member |
| [__ReflectProperty&nbsp;::&nbsp;isStatic__](reflect-ReflectProperty-isStatic.md) | Check to see if this property is `static` |
| [__ReflectProperty&nbsp;::&nbsp;hasType__](reflect-ReflectProperty-hasType.md) | Check to see if this property was defined with a type |
| [__ReflectProperty&nbsp;::&nbsp;getType__](reflect-ReflectProperty-getType.md) | Get the type that this property was defined with |
| [__ReflectProperty&nbsp;::&nbsp;getModifierNames__](reflect-ReflectProperty-getModifierNames.md) | Get the string representation of the modifiers |
| [__ReflectProperty&nbsp;::&nbsp;isPublic__](reflect-ReflectProperty-isPublic.md) | Check to see if this member is `public` |
| [__ReflectProperty&nbsp;::&nbsp;isPrivate__](reflect-ReflectProperty-isPrivate.md) | Check to see if this member is `private` |
| [__ReflectProperty&nbsp;::&nbsp;isProtected__](reflect-ReflectProperty-isProtected.md) | Check to see if this member is `protected` |
| [__ReflectProperty&nbsp;::&nbsp;isInherited__](reflect-ReflectProperty-isInherited.md) | Check to see if this is an inherited method of the current class |
| [__ReflectProperty&nbsp;::&nbsp;getClass__](reflect-ReflectProperty-getClass.md) | Get the current class that this member belongs to |
