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
use ReflectionProperty;
use ReflectionClass;
use Exception;
use Throwable;

/**
 * An abstraction for the PHP `ReflectionProperty`.
 */
class ReflectProperty extends ReflectMember {

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\Reflect")]
    const M_STATIC = Reflect::M_STATIC;

    /** @internal */
    protected ReflectionProperty $property;

    /**
     * @param $class
     *      A `string` containing a full class name or an instance of a PHP `ReflectionClass`.
     *      This MUST be a class that contains the constant. If this is `NULL`, then
     *      declaring class is used from `$property`.
     *
     * @param $property
     *      A `string` containing the name of the property or an instance of a PHP `ReflectionProperty`.
     *
     * @throws Exception
     *      This will throw an exception if the class or property does not exist, if they where passed as
     *      a `string`, or if the property does not belong to the class.
     *
     * @synopsis
     *      __construct(ReflectionClass|string, ReflectionProperty|string)
     *      __construct(null, ReflectionProperty)
     */
    public function __construct(ReflectionClass|string|null $class, ReflectionProperty|string $property) {
        parent::__construct(
            $class == null && !is_string($property) ?
                    $property->getDeclaringClass() : $class
        );

        if (is_string($property)) {
            try {
                $property = new ReflectionProperty($class->getName(), $property);

            } catch (Throwable $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }

        } else if (!$class->hasProperty($property->getName())) {
            throw new Exception("The method '{$property->getName()}' does not belong to the class '{$class->getName()}'");
        }

        $this->property = $property;
        $this->property->setAccessible(true);
    }

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\ReflectMember")]
    public function getOverrideClass(): ?ReflectClass {
         $attrs = $this->property->getAttributes();

         foreach ($attrs as $attr) {
             if (preg_match("/(\\\|^)Override$/", $attr->getName())) {
                 $parent = $this->new_ReflectClass($attr->getArguments()[0]);

                 if ($parent->hasProperty($this->getName())) {
                     return $parent;
                 }
             }
         }

         foreach ($this->class->getTraits() as $parent) {
             if ($parent->hasProperty($this->getName())) {
                 return $parent;
             }
         }

         if (($parent = $this->class->getParentClass()) != null) {
             if ($parent->hasProperty($this->getName())) {
                 return $parent;
             }
         }

         foreach ($this->class->getInterfaces() as $parent) {
             if ($parent->hasProperty($this->getName())) {
                 return $parent;
             }
         }

         return null;
     }

     /**
      * @inheritDoc
      */
     #[Override("im\reflect\ReflectMember")]
     public function getDeclaringClass(): ReflectClass {
         return $this->new_ReflectClass($this->property->getDeclaringClass());
     }

     /**
      * Check to see if the property has a default value.
      */
     public function hasDefaultValue(): bool {
         return $this->property->hasDefaultValue();
     }

     /**
      * Get the default value from this property.
      *
      * @return
      *     This method will return `NULL` if the property does not
      *     have a default value. However the property itself may also
      *     be initialized with a default value of `NULL`.
      *     Use `hasDefaultValue()` if you want to know if the property
      *     does in fact have a default value or not.
      */
     public function getDefaultValue(): mixed {
         return $this->property->getDefaultValue();
     }

     /**
      * Get the current value of this property.
      *
      * @param $instance
      *     An object to use if this is not a static property
      *
      * @return
      *     This will return `NULL` if the property has not yet been
      *     initialized in any way.
      */
     public function getValue(object $instance = null): mixed {
         if ($this->property->isInitialized($instance)) {
             return $this->property->getValue($instance);
         }

         return null;
     }

     /**
      * Change the value on this property
      *
      * @param $instance
      *     An object to use if this is not a static property
      *
      * @param $value
      *     The value to set on the property
      */
     public function setValue(object $instance = null, mixed $value): void {
         if ($instance != null) {
             $this->property->getValue($instance, $value);

         } else {
             $this->property->getValue($value);
         }
     }

     /**
      * @inheritDoc
      */
     #[Override("im\reflect\ReflectMember")]
     public function getName(): string {
         return $this->property->getName();
     }

     /**
      * @inheritDoc
      */
     #[Override("im\reflect\ReflectMember")]
     public function getDocComment(): ?string {
         return ($doc = $this->property->getDocComment()) !== false ? $doc : null;
     }

     /**
      * @inheritDoc
      */
     #[Override("im\reflect\ReflectMember")]
     public function getModifiers(): int {
         if ($this->class->isInterface()) {
             // Modifiers from interfaces sense here
             return 0;
         }

         return Reflect::fromPHPModifiers($this->property->getModifiers());
     }

     /**
      * Check to see if this property is `static`.
      *
      * @note
      *      This is equal to `$this->getModifiers() & Reflect::M_STATIC`
      */
    public function isStatic(): bool {
        return $this->getModifiers() & Reflect::M_STATIC > 0;
    }

    /**
     * Check to see if this property was defined with a type.
     */
    public function hasType(): bool {
        return $this->property->hasType();
    }

    /**
     * Get the type that this property was defined with.
     */
    public function getType(): ?ReflectType {
        if ($this->property->hasType()) {
            return $this->new_ReflectType($this->property->getType());
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\ReflectMember")]
    public function __toString(): string {
        $str = new StringBuilder();

        if (($mod = $this->getModifierNames()) != null) {
            $str->append($mod, " ");
        }

        if ($this->hasType()) {
            $str->append($this->getType(), " ");
        }

        $str->append("\$", $this->getName());

        if ($this->hasDefaultValue()) {
            $str->append(" = ", Reflect::unwrapValue( $this->getDefaultValue() ));
        }

        return $str->toString();
    }
}
