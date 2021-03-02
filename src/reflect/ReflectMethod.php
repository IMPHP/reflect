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

use im\util\IndexArray;
use im\util\Vector;
use im\util\StringBuilder;
use ReflectionParameter;
use ReflectionMethod;
use ReflectionClass;
use Exception;
use Throwable;

/**
 * An abstraction for the PHP `ReflectionMethod`.
 */
class ReflectMethod extends ReflectMember {

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

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\Reflect")]
    const M_STATIC = Reflect::M_STATIC;

    /** @internal */
    protected ReflectionMethod $method;

    /** @internal */
    protected ?ReflectClass $overrideClass = null;

    /** @internal */
    protected ?ReflectClass $declaringClass = null;

    /** @internal */
    protected ?ReflectType $returnType = null;

    /** @internal */
    protected ?IndexArray $parameters = null;

    /** @internal */
    protected static array $Natives = [
        "__get", "__callStatic", "__call", "__destruct", "__construct",
        "__wakeup", "__sleep", "__unset", "__isset", "__set",
        "__set_state", "__invoke", "__toString", "__unserialize", "__serialize",
        "__debugInfo", "__clone"
    ];

    /**
     * @param $class
     *      A `string` containing a full class name or an instance of a PHP `ReflectionClass`.
     *      This MUST be a class that contains the method. If this is `NULL`, then
     *      declaring class is used from `$method`.
     *
     * @param $method
     *      A `string` containing the name of the method or an instance of a PHP `ReflectionMethod`.
     *
     * @throws Exception
     *      This will throw an exception if the class or method does not exist, if they where passed as
     *      a `string`, or if the method does not belong to the class.
     *
     * @synopsis
     *      __construct(ReflectionClass|string, ReflectionMethod|string)
     *      __construct(null, ReflectionMethod)
     */
    public function __construct(ReflectionClass|string|null $class, ReflectionMethod|string $method) {
        parent::__construct(
            $class == null && !is_string($method) ?
                    $method->getDeclaringClass() : $class
        );

        if (is_string($method)) {
            try {
                $method = new ReflectionMethod($this->class->getName(), $method);

            } catch (Throwable $e) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }

        } else if (!$class->hasMethod($method->getName())) {
            throw new Exception("The method '{$method->getName()}' does not belong to the class '{$this->class->getName()}'");
        }

        $this->method = $method;
        $this->method->setAccessible(true);
    }

    /**
     * @internal
     */
    protected function new_ReflectParameter(ReflectionParameter $param): ReflectParameter {
        return new ReflectParameter($param);
    }

    /**
     * Invoke this method
     *
     * @param $instance
     *     An object to use if this is not a static method
     *
     * @param $args
     *      Arguments to pass to the method
     *
     * @return
     *      Returns the result from the method.
     *      If the method is a `void`, no value is returned.
     */
    public function invoke(object $instance = null, mixed ...$args): mixed {
        try {
            return $this->method->invoke($instance, ...$args);

        } catch (Throwable $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get a list of all the parameters defined with this method.
     *
     * @return
     *      This will return a `IndexArray` with a `ReflectParameter`
     *      for each of the defined parameters.
     */
    public function getParameters(): IndexArray {
        if ($this->parameters == null) {
            $this->parameters = new Vector();

            $params = $this->method->getParameters();
            foreach ($params as $param) {
                $this->parameters->add($this->new_ReflectParameter($param));
            }

            $this->parameters->lock();
        }

        return $this->parameters;
    }

    /**
     * Check to see if this method has any parameters.
     */
    public function hasParameters(): bool {
        return $this->method->getNumberOfParameters() > 0;
    }

    /**
     * Get the return type that this method was defined with.
     *
     * @return
     *      This will return `NULL` if this method was not defined with a return type.
     */
    public function getReturnType(): ?ReflectType {
        if ($this->returnType == null) {
            $type = $this->method->getReturnType();

            if ($type != null) {
                $this->returnType = $this->new_ReflectType($type);
            }
        }

        return $this->returnType;
    }

    /**
     * Check to see if this method has a return type defined.
     */
    public function hasReturnType(): bool {
        return $this->method->hasReturnType();
    }

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\ReflectMember")]
    public function getOverrideClass(): ?ReflectClass {
        if ($this->overrideClass == null) {
            $attrs = $this->method->getAttributes();

            foreach ($attrs as $attr) {
                 if (preg_match("/(\\\|^)Override$/", $attr->getName())) {
                     $parent = new ReflectionClass($attr->getArguments()[0]);

                     if ($parent->hasMethod($this->getName())) {
                         return ($this->overrideClass = $this->new_ReflectClass($parent));
                     }
                 }
            }

            foreach ($this->class->getTraits() as $parent) {
                 if ($parent->hasMethod($this->getName())) {
                     return ($this->overrideClass = $this->new_ReflectClass($parent));
                 }
            }

            if (($parent = $this->class->getParentClass()) != null) {
                 if ($parent->hasMethod($this->getName())) {
                     return ($this->overrideClass = $this->new_ReflectClass($parent));
                 }
            }

            foreach ($this->class->getInterfaces() as $parent) {
                 if ($parent->hasMethod($this->getName())) {
                     return ($this->overrideClass = $this->new_ReflectClass($parent));
                 }
            }
        }

        return $this->overrideClass;
    }

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\ReflectMember")]
    public function getDeclaringClass(): ReflectClass {
        if ($this->declaringClass == null) {
            $this->declaringClass = $this->new_ReflectClass($this->method->getDeclaringClass());
        }

        return $this->declaringClass;
    }

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\ReflectMember")]
    public function getName(): string {
        return $this->method->getName();
    }

    /**
     * @inheritDoc
     */
    #[Override("im\reflect\ReflectMember")]
    public function getDocComment(): ?string {
        return ($doc = $this->method->getDocComment()) !== false ? $doc : null;
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

        return Reflect::fromPHPModifiers($this->method->getModifiers());
    }

    /**
     * Check to see if this method is `abstract`.
     *
     * @note
     *      This is equal to `$this->getModifiers() & Reflect::M_ABSTRACT`
     */
    public function isAbstract(): bool {
        return $this->getModifiers() & Reflect::M_ABSTRACT > 0;
    }

    /**
     * Check to see if this method is `final`.
     *
     * @note
     *      This is equal to `$this->getModifiers() & Reflect::M_FINAL`
     */
    public function isFinal(): bool {
        return $this->getModifiers() & Reflect::M_FINAL > 0;
    }

    /**
     * Check to see if this method is `static`.
     *
     * @note
     *      This is equal to `$this->getModifiers() & Reflect::M_STATIC`
     */
    public function isStatic(): bool {
        return $this->getModifiers() & Reflect::M_STATIC > 0;
    }

    /**
     * Check to see if this method is a build-in method.
     *
     * Build-in methods are those used by PHP, like `__construct()`
     * or `__clone()`. The so-called `Magic Methods`.
     */
    public function isNative(): bool {
        return in_array($this->getName(), ReflectMethod::$Natives);
    }

    /**
     * Check to see if this method returns `by-reference`.
     */
    public function isByRef(): bool {
        return $this->method->returnsReference();
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

        if ($this->isByRef()) {
            $str->append("&");
        }

        $str->append($this->getName(), "(");

        $i = 0;
        foreach ($this->getParameters() as $param) {
            if ($i++ > 0) {
                $str->append(", ");
            }

            $str->append($param);
        }

        $str->append(")");

        if ($this->hasReturnType()) {
            $str->append(": ", $this->getReturnType());
        }

        return $str->toString();
    }
}
