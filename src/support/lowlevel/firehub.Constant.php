<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.1
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;
use FireHub\Core\Throwable\Error\LowLevel\Constant\ {
    AlreadyExistError, FailedToDefineError, NotDefinedError
};

use function constant;
use function define;
use function defined;

/**
 * ### Low-Level Constant proxy class
 *
 * Provides a thin, low-level API for accessing, defining, and inspecting PHP constants.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class Constant extends LowLevel {

    /**
     * ### Checks whether a given named constant exists
     *
     * This function works also with class constants and enum cases.
     * @since 1.0.0
     *
     * @param non-empty-string $name <p>
     * The constant name.
     * </p>
     *
     * @return bool True if the named constant given by the name parameter has been defined, false otherwise.
     *
     * @note This function works also with class constants and enum cases.
     */
    public static function defined (string $name):bool {

        return defined($name);

    }

    /**
     * ### Defines a named constant at runtime
     *
     * Creates a new global constant with the given name and value.
     * @since 1.0.0
     *
     * @uses Constant::defined() To check if the constant already exists before attempting to define it.
     *
     * @param non-empty-string $name <p>
     * The name of the constant.
     * </p>
     * @param null|array<array-key, mixed>|scalar $value <p>
     * The value of the constant.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Constant\AlreadyExistError If constant with the same name already
     * exists.
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Constant\FailedToDefineError If failed to define constant.
     *
     * @return true True on success.
     */
    public static function define (string $name, null|array|bool|float|int|string $value):true {

        return self::defined($name)
            ? throw new AlreadyExistError
            : (define($name, $value)
                ?: throw new FailedToDefineError
            );

    }

    /**
     * ### Returns the value of a constant
     *
     * Method Constant#value() is useful if you need to retrieve the value of a constant but don't know its name.
     * In other words, it is stored in a variable or returned by a function.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Constant::defined() To check if the constant is defined before attempting
     * to retrieve its value.
     *
     * @param non-empty-string $name <p>
     * The constant name.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Constant\NotDefinedError If the constant is not defined.
     *
     * @return mixed The value of the constant.
     *
     * @note This function works also with class constants and enum cases.
     */
    public static function value (string $name):mixed {

        return self::defined($name)
            ? constant($name)
            : throw new NotDefinedError;

    }

}