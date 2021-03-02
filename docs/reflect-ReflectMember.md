# [Reflection](reflect.md) / ReflectMember
 > im\reflect\ReflectMember
____

## Description
Base class for `ReflectClass` members.

## Synopsis
```php
abstract class ReflectMember implements Stringable {

    // Constants
    public M_PUBLIC = 1
    public M_PROTECTED = 2
    public M_PRIVATE = 4

    // Methods
    public __construct(ReflectionClass|string $class)
    abstract public getDeclaringClass(): im\reflect\ReflectClass
    abstract public getOverrideClass(): null|im\reflect\ReflectClass
    abstract public getName(): string
    abstract public getDocComment(): null|string
    abstract public getModifiers(): int
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
| [__ReflectMember&nbsp;::&nbsp;M\_PUBLIC__](reflect-ReflectMember-prop_M_PUBLIC.md) |  |
| [__ReflectMember&nbsp;::&nbsp;M\_PROTECTED__](reflect-ReflectMember-prop_M_PROTECTED.md) |  |
| [__ReflectMember&nbsp;::&nbsp;M\_PRIVATE__](reflect-ReflectMember-prop_M_PRIVATE.md) |  |

## Methods
| Name | Description |
| :--- | :---------- |
| [__ReflectMember&nbsp;::&nbsp;\_\_construct__](reflect-ReflectMember-__construct.md) |  |
| [__ReflectMember&nbsp;::&nbsp;getDeclaringClass__](reflect-ReflectMember-getDeclaringClass.md) | Get the class that declared this member |
| [__ReflectMember&nbsp;::&nbsp;getOverrideClass__](reflect-ReflectMember-getOverrideClass.md) | Get the class that this member is overriding |
| [__ReflectMember&nbsp;::&nbsp;getName__](reflect-ReflectMember-getName.md) | Get the name of this member |
| [__ReflectMember&nbsp;::&nbsp;getDocComment__](reflect-ReflectMember-getDocComment.md) | Get the DocComment from this member |
| [__ReflectMember&nbsp;::&nbsp;getModifiers__](reflect-ReflectMember-getModifiers.md) | Get the modifier flags for this member |
| [__ReflectMember&nbsp;::&nbsp;getModifierNames__](reflect-ReflectMember-getModifierNames.md) | Get the string representation of the modifiers |
| [__ReflectMember&nbsp;::&nbsp;isPublic__](reflect-ReflectMember-isPublic.md) | Check to see if this member is `public` |
| [__ReflectMember&nbsp;::&nbsp;isPrivate__](reflect-ReflectMember-isPrivate.md) | Check to see if this member is `private` |
| [__ReflectMember&nbsp;::&nbsp;isProtected__](reflect-ReflectMember-isProtected.md) | Check to see if this member is `protected` |
| [__ReflectMember&nbsp;::&nbsp;isInherited__](reflect-ReflectMember-isInherited.md) | Check to see if this is an inherited method of the current class |
| [__ReflectMember&nbsp;::&nbsp;getClass__](reflect-ReflectMember-getClass.md) | Get the current class that this member belongs to |
