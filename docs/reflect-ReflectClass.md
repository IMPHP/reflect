# [Reflection](reflect.md) / ReflectClass
 > im\reflect\ReflectClass
____

## Description
An abstraction for the PHP `ReflectionClass`.

## Synopsis
```php
class ReflectClass implements Stringable {

    // Constants
    public M_FINAL = 16
    public M_ABSTRACT = 32

    // Methods
    public __construct(ReflectionClass|string $class)
    public invoke(mixed ...$args): object
    public getName(): string
    public getFullName(): string
    public getPathName(): null|string
    public getModifiers(): int
    public getModifierNames(): null|string
    public getTraits(): im\util\IndexArray
    public getInterfaces(): im\util\IndexArray
    public getParentClass(): null|im\reflect\ReflectClass
    public hasConstant(string $name): bool
    public getConstant(string $name): null|im\reflect\ReflectConstant
    public getConstants(): im\util\IndexArray
    public hasProperty(string $name): bool
    public getProperty(string $name): null|im\reflect\ReflectProperty
    public getProperties(): im\util\IndexArray
    public hasMethod(string $name): bool
    public getMethod(string $name): null|im\reflect\ReflectMethod
    public getMethods(): im\util\IndexArray
    public isAbstract(): bool
    public isFinal(): bool
    public isTrait(): bool
    public isInterface(): bool
    public getDocComment(): null|string
}
```

## Constants
| Name | Description |
| :--- | :---------- |
| [__ReflectClass&nbsp;::&nbsp;M\_FINAL__](reflect-ReflectClass-prop_M_FINAL.md) |  |
| [__ReflectClass&nbsp;::&nbsp;M\_ABSTRACT__](reflect-ReflectClass-prop_M_ABSTRACT.md) |  |

## Methods
| Name | Description |
| :--- | :---------- |
| [__ReflectClass&nbsp;::&nbsp;\_\_construct__](reflect-ReflectClass-__construct.md) |  |
| [__ReflectClass&nbsp;::&nbsp;invoke__](reflect-ReflectClass-invoke.md) | Invoke the class constructor to get an instance object of this class |
| [__ReflectClass&nbsp;::&nbsp;getName__](reflect-ReflectClass-getName.md) | Get the name of this class |
| [__ReflectClass&nbsp;::&nbsp;getFullName__](reflect-ReflectClass-getFullName.md) | Get the full name of this class |
| [__ReflectClass&nbsp;::&nbsp;getPathName__](reflect-ReflectClass-getPathName.md) | Get the path name _(namespace)_ of this class |
| [__ReflectClass&nbsp;::&nbsp;getModifiers__](reflect-ReflectClass-getModifiers.md) | Get the modifier flags for this class |
| [__ReflectClass&nbsp;::&nbsp;getModifierNames__](reflect-ReflectClass-getModifierNames.md) | Get the string representation of the modifiers |
| [__ReflectClass&nbsp;::&nbsp;getTraits__](reflect-ReflectClass-getTraits.md) | Get a list of all the `Traits` that is used by this class |
| [__ReflectClass&nbsp;::&nbsp;getInterfaces__](reflect-ReflectClass-getInterfaces.md) | Get a list of all the `Interfaces` that is implemented in this class |
| [__ReflectClass&nbsp;::&nbsp;getParentClass__](reflect-ReflectClass-getParentClass.md) | Get the parent class to this class |
| [__ReflectClass&nbsp;::&nbsp;hasConstant__](reflect-ReflectClass-hasConstant.md) | Check to see if a constant exists in this class |
| [__ReflectClass&nbsp;::&nbsp;getConstant__](reflect-ReflectClass-getConstant.md) | Get a constant for this class |
| [__ReflectClass&nbsp;::&nbsp;getConstants__](reflect-ReflectClass-getConstants.md) | Get a list of all the constants in this class |
| [__ReflectClass&nbsp;::&nbsp;hasProperty__](reflect-ReflectClass-hasProperty.md) | Check to see if a property exists in this class |
| [__ReflectClass&nbsp;::&nbsp;getProperty__](reflect-ReflectClass-getProperty.md) | Get a property for this class |
| [__ReflectClass&nbsp;::&nbsp;getProperties__](reflect-ReflectClass-getProperties.md) | Get a list of all the properties in this class |
| [__ReflectClass&nbsp;::&nbsp;hasMethod__](reflect-ReflectClass-hasMethod.md) | Check to see if a method exists in this class |
| [__ReflectClass&nbsp;::&nbsp;getMethod__](reflect-ReflectClass-getMethod.md) | Get a method for this class |
| [__ReflectClass&nbsp;::&nbsp;getMethods__](reflect-ReflectClass-getMethods.md) | Get a list of all the methods in this class |
| [__ReflectClass&nbsp;::&nbsp;isAbstract__](reflect-ReflectClass-isAbstract.md) | Check to see if this class is `abstract` |
| [__ReflectClass&nbsp;::&nbsp;isFinal__](reflect-ReflectClass-isFinal.md) | Check to see if this class is `final` |
| [__ReflectClass&nbsp;::&nbsp;isTrait__](reflect-ReflectClass-isTrait.md) | Check to see if this class is a `Trait` |
| [__ReflectClass&nbsp;::&nbsp;isInterface__](reflect-ReflectClass-isInterface.md) | Check to see if this class is an `Interface` |
| [__ReflectClass&nbsp;::&nbsp;getDocComment__](reflect-ReflectClass-getDocComment.md) | Get the DocComment from this class |
