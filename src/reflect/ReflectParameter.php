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
use ReflectionParameter;
use ReflectionUnionType;
use ReflectionType;
use ReflectionMethod;
use Exception;
use Throwable;

/**
 * An abstraction for the PHP `ReflectionParameter`.
 */
class ReflectParameter {

    /** @internal */
    protected ?ReflectMethod $rmethod = null;

    /** @internal */
    protected ReflectionMethod $method;

    /** @internal */
    protected ReflectionParameter $param;

    /**
     * @param $method
     *      A `string` containing the full name of the method that the parameter belongs to, or
     *      an instance of the PHP `ReflectionMethod`. The `string` should be formated as `Class::Method`.
     *      If this is `NULL`, then declaring function is used from `$param`.
     *
     * @param $param
     *      An instance of the PHP `ReflectionParameter` or a `string`/`int` defining the parameter
     *      name or position.
     *
     * @synopsis
     *      __construct(ReflectionMethod|string, ReflectionParameter|string|int)
     *      __construct(null, ReflectionParameter)
     */
    public function __construct(ReflectionMethod|string|null $method, ReflectionParameter|string|int $param) {
        if (is_string($method)) {
            try {
                $method = new ReflectionMethod($method);

            } catch (Throwable $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }

        } else if ($method == null && !($param instanceof ReflectionParameter)) {
            throw new Exception("Cannot use `NULL` as method name");

        } else {
            $method = $param->getDeclaringFunction();
        }

        if (is_string($param) || is_int($param)) {
            $param = new ReflectionParameter(
                [$method->getDeclaringClass()->getName(), $method->getName()],
                $param
            );

        } else if ($method->getDeclaringClass()->getName() != $param->getDeclaringClass()->getName()) {
            throw new Exception("The parameter '$param->getName()' does not belong to the method '{$method->getName()}'");
        }

        $this->$method = $method;
        $this->param = $param;
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
    protected function new_ReflectMethod(ReflectionMethod $method): ReflectMethod {
        return new ReflectMethod(null, $method);
    }

    /**
     * Get the method that this parameter belongs to
     */
    public function getMethod(): ReflectMethod {
        if ($this->rmethod == null) {
            $this->rmethod = $this->new_ReflectMethod(null, $this->method);
        }

        return $this->rmethod;
    }

    /**
     * Get the name of this parameter
     */
    public function getName(): string {
        return $this->param->getName();
    }

    /**
     * Get the position of this parameter
     */
    public function getPosition(): int {
        return $this->param->getPosition();
    }

    /**
     * Check to see if this parameter allows `NULL` to be passed
     */
    public function isNullable(): bool {
        return $this->param->allowsNull();
    }

    /**
     * Check to see if this parameter is optional
     */
    public function isOptional(): bool {
        return $this->param->isOptional();
    }

    /**
     * Check to see if this parameter is passed by reference
     */
    public function isByRef(): bool {
        return $this->param->isPassedByReference();
    }

    /**
     * Check to see if this parameter is variadic
     */
    public function isVariadic(): bool {
        return $this->param->isVariadic();
    }

    /**
     * Check to see if this parameter has a type defined
     */
    public function hasType(): bool {
        return $this->param->hasType();
    }

    /**
     * Get the type that this parameter is defined with
     *
     * @return
     *      This will return `NULL` if the parameter does not have a type defined
     */
    public function getType(): ?ReflectType {
        if ($this->param->hasType()) {
            return $this->new_ReflectType($this->param->getType());
        }

        return null;
    }

    /**
     * Check to see if this parameter was defined with a default value
     */
    public function hasDefaultValue(): bool {
        /**
         * A variadic parameter is also optional,
         * but does not have default values.
         * The usage of `isDefaultValueAvailable()` is not very well documented,
         * but `getDefaultValue()` will throw an exception if a method does not
         * have a default value, so we will go that rute instead, since PHP's own documentation
         * is using `isOptional()` as an improper check.
         */
        if ($this->isOptional()) {
            try {
                $this->param->getDefaultValue();

                return true;

            } catch (Exception $e) {}
        }

        return false;
    }

    /**
     * Get the default value that this parameter was defined with.
     *
     * @return
     *      This method will return `NULL` if the parameter has no default value.
     *      Note though that the parameter itself may be defined with `NULL` as it's
     *      default value. Use `hasDefaultValue()` to see if the parameter actually
     *      has a default value.
     */
    public function getDefaultValue(): mixed {
        return $this->param->getDefaultValue();
    }

    /**
     * @php
     */
    public function __toString(): string {
        $str = new StringBuilder();

        if ($this->hasType()) {
            $str->append($this->getType(), " ");
        }

        if ($this->isByRef()) {
            $str->append("&");
        }

        if ($this->isVariadic()) {
            $str->append("...");
        }

        $str->append("\$", $this->getName());

        if ($this->hasDefaultValue()) {
            $str->append(" = ", Reflect::unwrapValue( $this->getDefaultValue() ));
        }

        return $str->toString();
    }
}
