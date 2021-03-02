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

use ReflectionNamedType;
use ReflectionType;

/**
 * An abstraction for the PHP `ReflectionType`.
 */
class ReflectType {

    /** @internal */
    protected ReflectionType $type;

    /**
     * @param $type
     *      An instance of the PHP `ReflectionNamedType`
     */
    public function __construct(ReflectionNamedType $type) {
        $this->type = $type;
    }

    /**
     * Det the name of the type
     */
    public function getName(): string {
        return $this->type->getName();
    }

    /**
     * Check to see if this type is a builtin PHP type
     */
    public function isNative(): bool {
        return $this->type->isBuiltin();
    }

    /**
     * Check to see if this type allows `NULL`
     */
    public function isNullable(): bool {
        return $this->type->allowsNull();
    }

    /**
     * @php
     */
    public function __toString(): string {
        if ($this->isNullable() && $this->getName() != "mixed") {
            return $this->getName() . "|null";
        }

        return $this->getName();
    }
}
