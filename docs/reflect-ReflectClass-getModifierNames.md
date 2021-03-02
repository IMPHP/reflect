# [Reflection](reflect.md) / [ReflectClass](reflect-ReflectClass.md) :: getModifierNames
 > im\reflect\ReflectClass
____

## Description
Get the string representation of the modifiers.

## Synopsis
```php
public getModifierNames(): null|string
```

## Return
This will return `NULL` if there are no modifiers

## Example 1
```php
final class MyClass {}

$class = new ReflectClass("MyClass");
echo $class->getModifierNames();
```

```
Output: final
```
