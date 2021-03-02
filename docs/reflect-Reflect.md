# [Reflection](reflect.md) / Reflect
 > im\reflect\Reflect
____

## Description
Home for basic tools that does not belong in a one-specific class

## Synopsis
```php
final class Reflect {

    // Constants
    public int M_PUBLIC = 0x01
    public int M_PROTECTED = 0x02
    public int M_PRIVATE = 0x04
    public int M_FINAL = 0x10
    public int M_ABSTRACT = 0x20
    public int M_STATIC = 0x40

    // Methods
    public static getModifierNames(int $modifiers): null|string
    public static fromPHPModifiers(int $phpModifiers): int
    public static toPHPModifiers(int $modifiers): int
    public static unwrapValue(mixed $value): string
}
```

## Constants
| Name | Description |
| :--- | :---------- |
| [__Reflect&nbsp;::&nbsp;M\_PUBLIC__](reflect-Reflect-prop_M_PUBLIC.md) | Modifier for a class or member that is public |
| [__Reflect&nbsp;::&nbsp;M\_PROTECTED__](reflect-Reflect-prop_M_PROTECTED.md) | Modifier for a class or member that is protected |
| [__Reflect&nbsp;::&nbsp;M\_PRIVATE__](reflect-Reflect-prop_M_PRIVATE.md) | Modifier for a class or member that is private |
| [__Reflect&nbsp;::&nbsp;M\_FINAL__](reflect-Reflect-prop_M_FINAL.md) | Modifier for a class or member that is final |
| [__Reflect&nbsp;::&nbsp;M\_ABSTRACT__](reflect-Reflect-prop_M_ABSTRACT.md) | Modifier for a class or member that is abstract |
| [__Reflect&nbsp;::&nbsp;M\_STATIC__](reflect-Reflect-prop_M_STATIC.md) | Modifier for a class or member that is static |

## Methods
| Name | Description |
| :--- | :---------- |
| [__Reflect&nbsp;::&nbsp;getModifierNames__](reflect-Reflect-getModifierNames.md) | Transform modifiers into their string names |
| [__Reflect&nbsp;::&nbsp;fromPHPModifiers__](reflect-Reflect-fromPHPModifiers.md) | Convert PHP modifiers into the version used by this library |
| [__Reflect&nbsp;::&nbsp;toPHPModifiers__](reflect-Reflect-toPHPModifiers.md) | Convert modifiers back into PHP modifiers |
| [__Reflect&nbsp;::&nbsp;unwrapValue__](reflect-Reflect-unwrapValue.md) | Convert values returned from the reflection classes into string representations |
