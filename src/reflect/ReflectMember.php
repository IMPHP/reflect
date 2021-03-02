<?php declare(strict_types=1);
/*
 * This file is part of the IMPHP Project: https://github.com/IMPHP
 *
 * Copyright (c) 2021 Daniel Bergløv, License: MIT
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO
 * THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
 * THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace im\reflect;

use ReflectionUnionType;
use ReflectionType;
use ReflectionClass;
use Exception;
use Throwable;

/**
 * Base class for `ReflectClass` members.
 */
abstract class ReflectMember {

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\Reflect")]
    const M_PUBLIC = Reflect::M_PUBLIC;

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\Reflect")]
    const M_PROTECTED = Reflect::M_PROTECTED;

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\Reflect")]
    const M_PRIVATE = Reflect::M_PRIVATE;

    /** @internal */
    protected ReflectionClass $class;

    /** @internal */
    protected ?ReflectClass $reflClass = null;

    /**
     * @param $class
     *      A `string` containing a full class name or an instance of a PHP `ReflectionClass`.
     *      This MUST be a class that contains the member associated with this instance.
     */
    public function __construct(ReflectionClass|string $class) {
        if (is_string($class)) {
            try {
                $class = new ReflectionClass($class);

            } catch (Throwable $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }
        }

        $this->class = $class;
    }

    /**
     * @internal
     */
    protected function new_ReflectType(ReflectionType $type): ReflectType {
        return $type instanceof ReflectionUnionType ?
                    new ReflectUnionType($type) : new ReflectType($type);
    }

    /**
     * @internal
     */
    protected function new_ReflectClass(ReflectionClass|string $class): ReflectClass {
        return new ReflectClass($class);
    }

    /**
     * Get the class that declared this member.
     *
     * If this is an inherited member, then this will return the clostest
     * parent class that declares this member. If the current class is
     * declaring class, then `getDeclaringClass() == getClass()`.
     */
    abstract function getDeclaringClass(): ReflectClass;

    /**
     * Get the class that this member is overriding.
     *
     * If a class implements an interface or extends another class
     * that originally declared this member, that class or interface
     * is returned.
     *
     * @note
     *      This can be forced using the attribute `#[Override("MyTrait")]`.
     *      This can be useful in cases where there is a link between two classes,
     *      but there is no real implementation or extenstion involved. One
     *      such example could be a `Trait`.
     *
     * @example
     *      ```php
     *      final class MyConstants {
     *          const M_MYCONST = 0x01;
     *          const M_MYOTHER = 0x02;
     *      }
     *
     *      class SomeClass {
     *
     *          #[Override("MyConstants")]
     *          const M_MYCONST = MyConstants::M_MYCONST
     *
     *          // ...
     *      }
     *
     *      $class = new ReflectClass("SomeClass");
     *      $const = $class->getConstant("M_MYCONST");
     *
     *      echo "Original = {$const->getDeclaringClass()->getName()}";
     *      echo "Parent = {$const->getOverrideClass()->getName()}";
     *      ```
     *
     *      ```
     *      Output:
     *
     *      Original = SomeClass
     *      Parent = MyConstants
     *      ```
     *
     * @example
     *      ```php
     *      interface MyBase {
     *          function someMethod();
     *      }
     *
     *      class SomeClass implements MyBase {
     *          public function someMethod() {}
     *      }
     *
     *      $class = new ReflectClass("SomeClass");
     *      $method = $class->getMethod("someMethod");
     *
     *      echo "Original = {$method->getDeclaringClass()->getName()}";
     *      echo "Parent = {$method->getOverrideClass()->getName()}";
     *      ```
     *
     *      ```
     *      Output:
     *
     *      Original = SomeClass
     *      Parent = MyBase
     *      ```
     */
    abstract function getOverrideClass(): ?ReflectClass;

    /**
     * Get the name of this member.
     */
    abstract function getName(): string;

    /**
     * Get the DocComment from this member.
     *
     * @return
     *      This will return `NULL` if the member does not have any DocComments.
     */
    abstract function getDocComment(): ?string;

    /**
     * Get the modifier flags for this member.
     *
     * @note
     *      This is NOT the PHP modifier flags.
     *      You can use the flags from the `Reflect` class or
     *      use the inherited ones in this class to interpret them.
     */
    abstract function getModifiers(): int;

    /**
     * @php
     */
    abstract function __toString(): string;

    /**
     * Get the string representation of the modifiers.
     *
     * @example
     *      ```php
     *      class MyClass {
     *
     *          final public function myMethod() {}
     *      }
     *
     *      $method = new ReflectMethod("MyClass", "myMethod");
     *      echo $method->getModifierNames();
     *      ```
     *
     *      ```
     *      Output: final public
     *      ```
     *
     * @return
     *      This will return `NULL` if there are no modifiers
     */
    public function getModifierNames(): ?string {
        return Reflect::getModifierNames( $this->getModifiers() );
    }

    /**
     * Check to see if this member is `public`.
     *
     * @note
     *      This is equal to `$this->getModifiers() & Reflect::M_PUBLIC`
     */
    public function isPublic(): bool {
        /*
         * PHP defaults to `public`, so no `private` or `protected` means `public`
         */
        return $this->getModifiers() & (Reflect::M_PRIVATE|Reflect::M_PROTECTED) == 0;
    }

    /**
     * Check to see if this member is `private`.
     *
     * @note
     *      This is equal to `$this->getModifiers() & Reflect::M_PRIVATE`
     */
    public function isPrivate(): bool {
        return $this->getModifiers() & Reflect::M_PRIVATE > 0;
    }

    /**
     * Check to see if this member is `protected`.
     *
     * @note
     *      This is equal to `$this->getModifiers() & Reflect::M_PROTECTED`
     */
    public function isProtected(): bool {
        return $this->getModifiers() & Reflect::M_PROTECTED > 0;
    }

    /**
     * Check to see if this is an inherited method of the current class.
     *
     * @return
     *      This returns `TRUE` when `$this->getClass()` does NOT equal `$this->getDeclaringClass()`
     */
    public function isInherited(): bool {
        return $this->getClass()->getFullName() != $this->getDeclaringClass()->getFullName();
    }

    /**
     * Get the current class that this member belongs to.
     */
    public function getClass(): ReflectClass {
        if ($this->reflClass == null) {
            $this->reflClass = new ReflectClass($this->class);
        }

        return $this->reflClass;
    }
}
