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
use ReflectionClassConstant;
use ReflectionClass;
use Exception;
use Throwable;

/**
 * An abstraction for the PHP `ReflectionClassConstant`.
 */
class ReflectConstant extends ReflectMember {

    /** @internal */
    protected ReflectionClassConstant $property;

    /**
     * @param $class
     *      A `string` containing a full class name or an instance of a PHP `ReflectionClass`.
     *      This MUST be a class that contains the property. If this is `NULL`, then
     *      declaring class is used from `$property`.
     *
     * @param $property
     *      A `string` containing the name of the constant or an instance of a PHP `ReflectionClassConstant`.
     *
     * @throws Exception
     *      This will throw an exception if the class or constant does not exist, if they where passed as
     *      a `string`, or if the constant does not belong to the class.
     *
     * @synopsis
     *      __construct(ReflectionClass|string, ReflectionClassConstant|string)
     *      __construct(null, ReflectionClassConstant)
     */
    public function __construct(ReflectionClass|string|null $class, ReflectionClassConstant|string $property) {
        parent::__construct(
            $class == null && !is_string($property) ?
                    $property->getDeclaringClass() : $class
        );

        if (is_string($property)) {
            try {
                $property = new ReflectionClassConstant($class->getName(), $property);

            } catch (Throwable $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }

        } else if (!$class->hasConstant($property->getName())) {
            throw new Exception("The method '{$property->getName()}' does not belong to the class '{$class->getName()}'");
        }

        $this->property = $property;
    }

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\ReflectMember")]
    public function getDeclaringClass(): ReflectClass {
        return $this->new_ReflectClass($this->property->getDeclaringClass());
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

                 if ($parent->hasConstant($this->getName())) {
                     return $parent;
                 }
             }
         }

         if (($parent = $this->class->getParentClass()) != null) {
             if ($parent->hasConstant($this->getName())) {
                 return $parent;
             }
         }

         foreach ($this->class->getInterfaces() as $parent) {
             if ($parent->hasConstant($this->getName())) {
                 return $parent;
             }
         }

         return null;
     }

     /**
      * Get the value from this constant
      */
     public function getValue(): mixed {
          return $this->property->getValue();
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
      * @inheritDoc
      */
     #[Override("im\reflect\ReflectMember")]
     public function __toString(): string {
         $str = new StringBuilder();

         if (($mod = $this->getModifierNames()) != null) {
             $str->append($mod, " ");
         }

         $str->append($this->getName(), " = ", Reflect::unwrapValue( $this->getValue() ));

         return $str->toString();
     }
}
