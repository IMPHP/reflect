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

use ReflectionClass as RCL;
use ReflectionMethod as RM;
use ReflectionProperty as RP;
use ReflectionClassConstant as RC;

/**
 * Home for basic tools that does not belong in a one-specific class
 */
final class Reflect {

    /**
     * Modifier for a class or member that is public
     *
     * @var int = 0x01
     */
    public const M_PUBLIC = 0x01;

    /**
     * Modifier for a class or member that is protected
     *
     * @var int = 0x02
     */
    public const M_PROTECTED = 0x02;

    /**
     * Modifier for a class or member that is private
     *
     * @var int = 0x04
     */
    public const M_PRIVATE = 0x04;

    /**
     * Modifier for a class or member that is final
     *
     * @var int = 0x10
     */
    public const M_FINAL = 0x10;

    /**
     * Modifier for a class or member that is abstract
     *
     * @var int = 0x20
     */
    public const M_ABSTRACT = 0x20;

    /**
     * Modifier for a class or member that is static
     *
     * @var int = 0x40
     */
    public const M_STATIC = 0x40;

    /**
     * Transform modifiers into their string names
     *
     * @example
     *      ```php
     *      echo Reflect::getModifierNames( 0x11 );
     *      ```
     *
     *      ```
     *      Output:
     *
     *      final public
     *      ```
     *
     * @param $modifiers
     *      Modifiers like `Reflect::M_PUBLIC|Reflect::M_ABSTRACT`
     */
    public static function getModifierNames(int $modifiers): ?string {
        if (($modifiers & 0x77) == 0) {
            return null;
        }

        $mods = [
            Reflect::M_FINAL => "final",
            Reflect::M_PUBLIC => "public",
            Reflect::M_PROTECTED => "protected",
            Reflect::M_PRIVATE => "private",
            Reflect::M_STATIC => "static",
            Reflect::M_ABSTRACT => "abstract"
        ];

        foreach ($mods as $flag => $mod) {
            if (($modifiers & $flag) == 0) {
                unset($mods[$flag]);
            }
        }

        return implode(" ", $mods);
    }

    /**
     * Convert PHP modifiers into the version used by this library
     *
     * @param $phpModifiers
     *      The PHP modifiers
     */
    public static function fromPHPModifiers(int $phpModifiers): int {
        /*
         * This is a mess, like most in this PHP Reflection library.
         * These values are scattered across multiple classes and their actual
         * values does NOT match the documented values. So to be sure, we add
         * them all, and convert them into something more consistent.
         *
         * Example:
         *      ReflectionMethod::IS_PUBLIC gives value(1), but documentation
         *      states that this should be (256) and that `IS_STATIC`
         *      should be (1). The highest actual value is (64) with `IS_ABSTRACT`
         */
        $mods = [
            RCL::IS_FINAL|RM::IS_FINAL                              => Reflect::M_FINAL,
            RM::IS_PUBLIC|RP::IS_PUBLIC|RC::IS_PUBLIC               => Reflect::M_PUBLIC,
            RM::IS_PROTECTED|RP::IS_PROTECTED|RC::IS_PROTECTED      => Reflect::M_PROTECTED,
            RM::IS_PRIVATE|RP::IS_PRIVATE|RC::IS_PRIVATE            => Reflect::M_PRIVATE,
            RM::IS_STATIC|RP::IS_STATIC                             => Reflect::M_STATIC,
            RCL::IS_EXPLICIT_ABSTRACT|RM::IS_ABSTRACT               => Reflect::M_ABSTRACT
        ];

        /*
         * Note: `IS_IMPLICIT_ABSTRACT` shares value(16) with `IS_STATIC`
         */

        $ret = 0;

        foreach ($mods as $flag => $mod) {
            if (($phpModifiers & $flag) > 0) {
                $ret |= $mod;
            }
        }

        return $ret;
    }

    /**
     * Convert modifiers back into PHP modifiers
     *
     * @param $modifiers
     *      Modifiers used by this library
     *
     * @return
     *      PHP version modifiers
     */
    public static function toPHPModifiers(int $modifiers): int {
        $mod = [
            Reflect::M_FINAL        => RM::IS_FINAL,
            Reflect::M_PUBLIC       => RM::IS_PUBLIC,
            Reflect::M_PROTECTED    => RM::IS_PROTECTED,
            Reflect::M_PRIVATE      => RM::IS_PRIVATE,
            Reflect::M_STATIC       => RM::IS_STATIC,
            Reflect::M_ABSTRACT     => RM::IS_ABSTRACT
        ];

        $ret = 0;

        foreach ($mods as $flag => $mod) {
            if (($modifiers & $flag) > 0) {
                $ret |= $mod;
            }
        }

        return $ret;
    }

    /**
     * Convert values returned from the reflection classes into string representations
     *
     * @param $value
     *      Value to convert
     */
    public static function unwrapValue(mixed $value): string {
        return match (true) {
            is_null($value) => "NULL",
            is_bool($value) => $value ? "TRUE" : "FALSE",
            is_numeric($value) => strval($value),
            is_string($value) => "'$value'",
            default => strval($value)
        };
    }
}
