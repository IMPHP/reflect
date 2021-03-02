# [Reflection](reflect.md) / [Reflect](reflect-Reflect.md) :: getModifierNames
 > im\reflect\Reflect
____

## Description
Transform modifiers into their string names

## Synopsis
```php
public static getModifierNames(int $modifiers): null|string
```

## Parameters
| Name | Description |
| :--- | :---------- |
| modifiers | Modifiers like `Reflect::M_PUBLIC\|Reflect::M_ABSTRACT` |

## Example 1
```php
echo Reflect::getModifierNames( 0x11 );
```

```
Output:

final public
```
