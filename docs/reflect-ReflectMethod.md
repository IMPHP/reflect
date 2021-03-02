# [Reflection](reflect.md) / ReflectMethod
 > im\reflect\ReflectMethod
____

## Description
An abstraction for the PHP `ReflectionMethod`.

## Synopsis
```php
class ReflectMethod extends im\reflect\ReflectMember implements Stringable {

    // Constants
    public M_FINAL = 16
    public M_ABSTRACT = 32
    public M_STATIC = 64

    // Inherited Constants
    public M_PUBLIC = 1
    public M_PROTECTED = 2
    public M_PRIVATE = 4

    // Methods
    public __construct(ReflectionClass|string|null $class, ReflectionMethod|string $method)
    public invoke(null|object $instance = NULL, mixed ...$args): mixed
    public getParameters(): im\util\IndexArray
    public hasParameters(): bool
    public getReturnType(): null|im\reflect\ReflectType
    public hasReturnType(): bool
    public getOverrideClass(): null|im\reflect\ReflectClass
    public getDeclaringClass(): im\reflect\ReflectClass
    public getName(): string
    public getDocComment(): null|string
    public getModifiers(): int
    public isAbstract(): bool
    public isFinal(): bool
    public isStatic(): bool
    public isNative(): bool
    public isByRef(): bool

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
| [__ReflectMethod&nbsp;::&nbsp;M\_FINAL__](reflect-ReflectMethod-prop_M_FINAL.md) |  |
| [__ReflectMethod&nbsp;::&nbsp;M\_ABSTRACT__](reflect-ReflectMethod-prop_M_ABSTRACT.md) |  |
| [__ReflectMethod&nbsp;::&nbsp;M\_STATIC__](reflect-ReflectMethod-prop_M_STATIC.md) |  |
| [__ReflectMethod&nbsp;::&nbsp;M\_PUBLIC__](reflect-ReflectMethod-prop_M_PUBLIC.md) |  |
| [__ReflectMethod&nbsp;::&nbsp;M\_PROTECTED__](reflect-ReflectMethod-prop_M_PROTECTED.md) |  |
| [__ReflectMethod&nbsp;::&nbsp;M\_PRIVATE__](reflect-ReflectMethod-prop_M_PRIVATE.md) |  |

## Methods
| Name | Description |
| :--- | :---------- |
| [__ReflectMethod&nbsp;::&nbsp;\_\_construct__](reflect-ReflectMethod-__construct.md) |  |
| [__ReflectMethod&nbsp;::&nbsp;invoke__](reflect-ReflectMethod-invoke.md) | Invoke this method |
| [__ReflectMethod&nbsp;::&nbsp;getParameters__](reflect-ReflectMethod-getParameters.md) | Get a list of all the parameters defined with this method |
| [__ReflectMethod&nbsp;::&nbsp;hasParameters__](reflect-ReflectMethod-hasParameters.md) | Check to see if this method has any parameters |
| [__ReflectMethod&nbsp;::&nbsp;getReturnType__](reflect-ReflectMethod-getReturnType.md) | Get the return type that this method was defined with |
| [__ReflectMethod&nbsp;::&nbsp;hasReturnType__](reflect-ReflectMethod-hasReturnType.md) | Check to see if this method has a return type defined |
| [__ReflectMethod&nbsp;::&nbsp;getOverrideClass__](reflect-ReflectMethod-getOverrideClass.md) | Get the class that this member is overriding |
| [__ReflectMethod&nbsp;::&nbsp;getDeclaringClass__](reflect-ReflectMethod-getDeclaringClass.md) | Get the class that declared this member |
| [__ReflectMethod&nbsp;::&nbsp;getName__](reflect-ReflectMethod-getName.md) | Get the name of this member |
| [__ReflectMethod&nbsp;::&nbsp;getDocComment__](reflect-ReflectMethod-getDocComment.md) | Get the DocComment from this member |
| [__ReflectMethod&nbsp;::&nbsp;getModifiers__](reflect-ReflectMethod-getModifiers.md) | Get the modifier flags for this member |
| [__ReflectMethod&nbsp;::&nbsp;isAbstract__](reflect-ReflectMethod-isAbstract.md) | Check to see if this method is `abstract` |
| [__ReflectMethod&nbsp;::&nbsp;isFinal__](reflect-ReflectMethod-isFinal.md) | Check to see if this method is `final` |
| [__ReflectMethod&nbsp;::&nbsp;isStatic__](reflect-ReflectMethod-isStatic.md) | Check to see if this method is `static` |
| [__ReflectMethod&nbsp;::&nbsp;isNative__](reflect-ReflectMethod-isNative.md) | Check to see if this method is a build-in method |
| [__ReflectMethod&nbsp;::&nbsp;isByRef__](reflect-ReflectMethod-isByRef.md) | Check to see if this method returns `by-reference` |
| [__ReflectMethod&nbsp;::&nbsp;getModifierNames__](reflect-ReflectMethod-getModifierNames.md) | Get the string representation of the modifiers |
| [__ReflectMethod&nbsp;::&nbsp;isPublic__](reflect-ReflectMethod-isPublic.md) | Check to see if this member is `public` |
| [__ReflectMethod&nbsp;::&nbsp;isPrivate__](reflect-ReflectMethod-isPrivate.md) | Check to see if this member is `private` |
| [__ReflectMethod&nbsp;::&nbsp;isProtected__](reflect-ReflectMethod-isProtected.md) | Check to see if this member is `protected` |
| [__ReflectMethod&nbsp;::&nbsp;isInherited__](reflect-ReflectMethod-isInherited.md) | Check to see if this is an inherited method of the current class |
| [__ReflectMethod&nbsp;::&nbsp;getClass__](reflect-ReflectMethod-getClass.md) | Get the current class that this member belongs to |
