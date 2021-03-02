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
use ReflectionUnionType;
use ReflectionType;

/**
 * An abstraction for the PHP `ReflectionUnionType`.
 *
 * This class properly extends `ReflectType`, just like
 * PHP should have done with it's `ReflectionUnionType`
 * vs `ReflectionNamedType`.
 */
class ReflectUnionType extends ReflectType {

    /** @internal */
    protected IndexArray $types;

    /**
     * @param $type
     *      An instance of the PHP `ReflectionUnionType`
     */
    public function __construct(ReflectionUnionType $type) {
        $this->type = $type;
        $this->types = new Vector();

        foreach ($type->getTypes() as $stype) {
            $this->types->add( $this->new_ReflectType($stype) );
        }

        $this->types->lock();
    }

    /**
     * @internal
     */
    protected function new_ReflectType(ReflectionType $type): ReflectType {
        return new ReflectType($type);
    }

    /**
     * Get a list of all the types in this union.
     *
     * @return
     *      This will return a list of `ReflectType`
     *      for each type in the union.
     */
    public function getTypes(): IndexArray {
        return $this->types;
    }

    /**
     * Get the names of this union type.
     * This will return the complete union string of types.
     */
    #[Override("im\reflect\ReflectType")]
    public function getName(): string {
        return $this->types->join("|");
    }

    /**
     * Check to see if all types in the union are builtin
     * PHP types.
     */
    #[Override("im\reflect\ReflectType")]
    public function isNative(): bool {
        foreach ($this->getTypes() as $type) {
            if (!$type->isBuiltin()) {
                return false;
            }
        }

        return true;
    }
}
