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

use im\util\StringBuilder;
use im\util\MapArray;
use im\util\IndexArray;
use im\util\Vector;
use im\util\Map;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use ReflectionClassConstant;
use Exception;
use Throwable;

/**
 * An abstraction for the PHP `ReflectionClass`.
 */
class ReflectClass {

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\Reflect")]
    const M_FINAL = Reflect::M_FINAL;

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\Reflect")]
    const M_ABSTRACT = Reflect::M_ABSTRACT;

    /** @internal */
    protected ReflectionClass $class;

    /** @internal */
    protected ?ReflectClass $parent = null;

    /** @internal */
    protected MapArray $methods;

    /** @internal */
    protected ?IndexArray $methodList = null;

    /** @internal */
    protected MapArray $properties;

    /** @internal */
    protected ?IndexArray $propertyList = null;

    /** @internal */
    protected MapArray $constants;

    /** @internal */
    protected ?IndexArray $constantList = null;

    /** @internal */
    protected ?IndexArray $interfaceList = null;

    /** @internal */
    protected ?IndexArray $traitList = null;

    /**
     * @param $class
     *      A `string` containing the full class name or an instance of the PHP `ReflectionClass`
     *
     * @throws Exception
     *      This will throw an exception if the class does not exist, if it was passed as
     *      a `string`.
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
        $this->methods = new Map();
        $this->properties = new Map();
        $this->constants = new Map();
    }

    /**
     * @internal
     */
    protected function new_ReflectMethod(ReflectionClass|string $class, ReflectionMethod|string $method): ReflectMethod {
        return new ReflectMethod($class, $method);
    }

    /**
     * @internal
     */
    protected function new_ReflectProperty(ReflectionClass|string $class, ReflectionProperty|string $property): ReflectProperty {
        return new ReflectProperty($class, $property);
    }

    /**
     * @internal
     */
    protected function new_ReflectConstant(ReflectionClass|string $class, ReflectionClassConstant|string $constant): ReflectConstant {
        return new ReflectConstant($class, $constant);
    }

    /**
     * @internal
     */
    protected function new_ReflectClass(ReflectionClass|string $class): ReflectClass {
        return new ReflectClass($class);
    }

    /**
     * Invoke the class constructor to get an instance object of this class.
     *
     * This object can also be used in other reflection classes
     * such as `ReflectMethod`, `ReflectConstant` and `ReflectProperty` to
     * interact with the object through this reflection library.
     *
     * @note
     *      Unlike the PHP `ReflectionClass::newInstance()`, this method can access
     *      any constructor regardless of whether it is a `private` or `protected`
     *      constructor, even if they are inherited or non-existing.
     *
     * @param $args
     *      Arguments to pass to the constructor
     */
    public function invoke(mixed ...$args): object {
        try {
            return $this->class->newInstance(...$args);

        } catch (Throwable $e) {
            try {
                $object = $this->class->newInstanceWithoutConstructor();

                if ($this->class->hasMethod("__construct")) {
                    $method = $this->class->getMethod("__construct");
                    $method->setAccessible(true);
                    $method->invoke($object, ...$args);
                }

                return $object;

            } catch (Throwable $ei) {
                throw new Exception($ei->getMessage(), $ei->getCode(), $ei);
            }
        }
    }

    /**
     * Get the name of this class.
     *
     * @note
     *      This is the class name and does not include namespace.
     */
    public function getName(): string {
        return $this->class->getShortName();
    }

    /**
     * Get the full name of this class. This includes the
     * namespace, if pressent.
     */
    public function getFullName(): string {
        return $this->class->getName();
    }

    /**
     * Get the path name _(namespace)_ of this class.
     *
     * @return
     *      This will return `NULL` if the class does not belong to a namespace.
     */
    public function getPathName(): ?string {
        return ($path = $this->class->getNamespaceName()) != "" ? $path : null;
    }

    /**
     * Get the modifier flags for this class.
     *
     * @note
     *      This is NOT the PHP modifier flags.
     *      You can use the flags from the `Reflect` class or
     *      use the inherited ones in this class to interpret them.
     */
    public function getModifiers(): int {
        $mod = $this->class->getModifiers();

        /*
         * The `IS_IMPLICIT_ABSTRACT` conflicts with
         * `IS_STATIC` (Both = 16). Remove it and replace it with `IS_EXPLICIT_ABSTRACT`.
         * It's not that important. The class is abstract in both regards.
         */
        if ($mod & ReflectionClass::IS_IMPLICIT_ABSTRACT) {
            $mod &= ~ReflectionClass::IS_IMPLICIT_ABSTRACT;
            $mod |= ReflectionClass::IS_EXPLICIT_ABSTRACT;
        }

        return Reflect::fromPHPModifiers($mod);
    }

    /**
     * Get the string representation of the modifiers.
     *
     * @example
     *      ```php
     *      final class MyClass {}
     *
     *      $class = new ReflectClass("MyClass");
     *      echo $class->getModifierNames();
     *      ```
     *
     *      ```
     *      Output: final
     *      ```
     *
     * @return
     *      This will return `NULL` if there are no modifiers
     */
    public function getModifierNames(): ?string {
        return Reflect::getModifierNames( $this->getModifiers() );
    }

    /**
     * Get a list of all the `Traits` that is used by this class.
     *
     * @return
     *      This will return a `IndexArray` with a `ReflectClass`
     *      for each of the used traits.
     */
    public function getTraits(): IndexArray {
        if ($this->traitList == null) {
            $this->traitList = new Vector();

            /*
             * Documentation states that NULL may be returned
             */
            if (($traits = $this->class->getTraits()) != null) {
                foreach ($traits as $trait) {
                    $this->traitList->add($this->new_ReflectClass($trait));
                }
            }

            $this->traitList->lock();
        }

        return $this->traitList;
    }

    /**
     * Get a list of all the `Interfaces` that is implemented in this class.
     *
     * @return
     *      This will return a `IndexArray` with a `ReflectClass`
     *      for each of the implemented interfaces.
     */
    public function getInterfaces(): IndexArray {
        if ($this->interfaceList == null) {
            $this->interfaceList = new Vector();

            foreach ($this->class->getInterfaces() as $interface) {
                $this->interfaceList->add($this->new_ReflectClass($interface));
            }

            $this->interfaceList->lock();
        }

        return $this->interfaceList;
    }

    /**
     * Get the parent class to this class.
     *
     * @return
     *      This will return `NULL` if this class does not extend another class.
     */
    public function getParentClass(): ?ReflectClass {
        if ($this->parent == null) {
            if (($parent = $this->class->getParentClass()) !== false) {
                $this->parent = $this->new_ReflectClass($parent);
            }
        }

        return $this->parent;
    }

    /**
     * Check to see if a constant exists in this class.
     *
     * @param $name
     *      Name of the constant to look for
     */
    public function hasConstant(string $name): bool {
        return $this->constants->isset($name)
                    || $this->class->hasConstant($name);
    }

    /**
     * Get a constant for this class
     *
     * @param $name
     *      Name of the constant to return
     *
     * @throws Exception
     *      This will throw an exception if the constant does not exist
     */
    public function getConstant(string $name): ?ReflectConstant {
        if (!$this->constants->isset($name)) {
            try {
                $this->constants->set(
                    $name,
                    $this->new_ReflectConstant($this->class, $this->class->getReflectionConstant($name))
                );

            } catch (Throwable $e) {
                return null;
            }
        }

        return $this->constants->get($name);
    }

    /**
     * Get a list of all the constants in this class.
     *
     * @return
     *      This will return a `IndexArray` with a `ReflectConstant`
     *      for each constant in the class.
     */
    public function getConstants(): IndexArray {
        if ($this->constantList == null) {
            $this->constantList = new Vector();

            foreach ($this->class->getReflectionConstants() as $constant) {
                $name = $constant->getName();

                if (!$this->constants->isset($name)) {
                    $this->constants->set(
                        $name,
                        $this->new_ReflectConstant($this->class, $constant)
                    );
                }

                $this->constantList->add(
                    $this->constants->get($name)
                );
            }

            $this->constantList->lock();
        }

        return $this->constantList;
    }

    /**
     * Check to see if a property exists in this class.
     *
     * @param $name
     *      Name of the property to look for
     */
    public function hasProperty(string $name): bool {
        return $this->properties->isset($name)
                    || $this->class->hasProperty($name);
    }

    /**
     * Get a property for this class
     *
     * @param $name
     *      Name of the property to return
     *
     * @throws Exception
     *      This will throw an exception if the property does not exist
     */
    public function getProperty(string $name): ?ReflectProperty {
        if (!$this->properties->isset($name)) {
            try {
                $this->properties->set(
                    $name,
                    $this->new_ReflectProperty($this->class, $this->class->getProperty($name))
                );

            } catch (Throwable $e) {
                return null;
            }
        }

        return $this->properties->get($name);
    }

    /**
     * Get a list of all the properties in this class.
     *
     * @return
     *      This will return a `IndexArray` with a `ReflectProperty`
     *      for each property in the class.
     */
    public function getProperties(): IndexArray {
        if ($this->propertyList == null) {
            $this->propertyList = new Vector();

            foreach ($this->class->getProperties() as $property) {
                $name = $property->getName();

                if (!$this->properties->isset($name)) {
                    $this->properties->set(
                        $name,
                        $this->new_ReflectProperty($this->class, $property)
                    );
                }

                $this->propertyList->add(
                    $this->properties->get($name)
                );
            }

            $this->propertyList->lock();
        }

        return $this->propertyList;
    }

    /**
     * Check to see if a method exists in this class.
     *
     * @param $name
     *      Name of the method to look for
     */
    public function hasMethod(string $name): bool {
        return $this->methods->isset($name)
                    || $this->class->hasMethod($name);
    }

    /**
     * Get a method for this class
     *
     * @param $name
     *      Name of the method to return
     */
    public function getMethod(string $name): ?ReflectMethod {
        if (!$this->methods->isset($name)) {
            try {
                $this->methods->set(
                    $name,
                    $this->new_ReflectMethod($this->class, $this->class->getMethod($name))
                );

            } catch (Throwable $e) {
                return null;
            }
        }

        return $this->methods->get($name);
    }

    /**
     * Get a list of all the methods in this class.
     *
     * @return
     *      This will return a `IndexArray` with a `ReflectMethod`
     *      for each method in the class.
     */
    public function getMethods(): IndexArray {
        if ($this->methodList == null) {
            $this->methodList = new Vector();

            foreach ($this->class->getMethods() as $method) {
                $name = $method->getName();

                if (!$this->methods->isset($name)) {
                    $this->methods->set(
                        $name,
                        $this->new_ReflectMethod($this->class, $method)
                    );
                }

                $this->methodList->add(
                    $this->methods->get($name)
                );
            }

            $this->methodList->lock();
        }

        return $this->methodList;
    }

    /**
     * Check to see if this class is `abstract`.
     *
     * @note
     *      This is equal to `$this->getModifiers() & Reflect::M_ABSTRACT`
     */
    public function isAbstract(): bool {
        return $this->getModifiers() & Reflect::M_ABSTRACT > 0;
    }

    /**
     * Check to see if this class is `final`.
     *
     * @note
     *      This is equal to `$this->getModifiers() & Reflect::M_FINAL`
     */
    public function isFinal(): bool {
        return $this->getModifiers() & Reflect::M_FINAL > 0;
    }

    /**
     * Check to see if this class is a `Trait`.
     */
    public function isTrait(): bool {
        return $this->class->isTrait();
    }

    /**
     * Check to see if this class is an `Interface`.
     */
    public function isInterface(): bool {
        return $this->class->isInterface();
    }

    /**
     * Get the DocComment from this class.
     *
     * @return
     *      This will return `NULL` if the class does not have any DocComments.
     */
    public function getDocComment(): ?string {
        return ($doc = $this->property->getDocComment()) !== false ? $doc : null;
    }

    /**
     * @php
     */
    public function __toString(): string {
        $str = new StringBuilder();

        if (($mod = $this->getModifierNames()) != null) {
            $str->append($mod, " ");
        }

        $type = match (true) {
            $this->isInterface() => "interface",
            $this->isTrait() => "trait",
            default => "class"
        };

        $str->append($type, " ", $this->getName());

        if (($parent = $this->getParentClass()) != null) {
            $str->append(" extends ", $parent->getFullName());
        }

        $ifaces = $this->getInterfaces();
        $traits = $this->getTraits();

        if ($traits->length() > 0) {
            $i=0;

            $str->append(" uses ");

            foreach ($traits as $trait) {
                if ($i++ > 0) {
                    $str->append(", ");
                }

                $str->append($trait->getFullName());
            }
        }

        if ($ifaces->length() > 0) {
            $i=0;

            $str->append(" implements ");

            foreach ($ifaces as $iface) {
                if ($i++ > 0) {
                    $str->append(", ");
                }

                $str->append($iface->getFullName());
            }
        }

        return $str->toString();
    }
}
