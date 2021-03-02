# [Reflection](reflect.md) / [ReflectMember](reflect-ReflectMember.md) :: getModifierNames
 > im\reflect\ReflectMember
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
class MyClass {

    final public function myMethod() {}
}

$method = new ReflectMethod("MyClass", "myMethod");
echo $method->getModifierNames();
```

```
Output: final public
```
