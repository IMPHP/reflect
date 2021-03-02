# [Reflection](reflect.md) / [ReflectMethod](reflect-ReflectMethod.md) :: getOverrideClass
 > im\reflect\ReflectMethod
____

## Description
Get the class that this member is overriding.

If a class implements an interface or extends another class
that originally declared this member, that class or interface
is returned.

 > This can be forced using the attribute `#[Override("MyTrait")]`. This can be useful in cases where there is a link between two classes, but there is no real implementation or extenstion involved. One such example could be a `Trait`.  

## Synopsis
```php
public getOverrideClass(): null|im\reflect\ReflectClass
```

## Example 1
```php
final class MyConstants {
    const M_MYCONST = 0x01;
    const M_MYOTHER = 0x02;
}

class SomeClass {

    #[Override("MyConstants")]
    const M_MYCONST = MyConstants::M_MYCONST

    // ...
}

$class = new ReflectClass("SomeClass");
$const = $class->getConstant("M_MYCONST");

echo "Original = {$const->getDeclaringClass()->getName()}";
echo "Parent = {$const->getOverrideClass()->getName()}";
```

```
Output:

Original = SomeClass
Parent = MyConstants
```

## Example 2
```php
interface MyBase {
    function someMethod();
}

class SomeClass implements MyBase {
    public function someMethod() {}
}

$class = new ReflectClass("SomeClass");
$method = $class->getMethod("someMethod");

echo "Original = {$method->getDeclaringClass()->getName()}";
echo "Parent = {$method->getOverrideClass()->getName()}";
```

```
Output:

Original = SomeClass
Parent = MyBase
```
