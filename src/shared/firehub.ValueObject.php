<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.2
 * @package Core\Shared
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Shared;

use FireHub\Core\Throwable\Error\LowLevel\InvalidValueObjectError;

/**
 * ### Base Value Object
 *
 * Base class for all value objects in the FireHub ecosystem.
 * @since 1.0.0
 *
 * @template TValue
 */
abstract readonly class ValueObject {

    /**
     * ### Returns the raw value of the VO
     * @since 1.0.0
     *
     * @return TValue Raw VO value.
     */
    abstract public function value ():mixed;

    /**
     * ### Compares two VOs
     * @since 1.0.0
     *
     * @uses static::value() To get the raw value for both VOs.
     *
     * @param self<TValue> $other <p>
     * VO to compare with.
     * </p>
     *
     * @return bool True if both VOs as equal, false otherwise.
     */
    public function equals (self $other):bool {

        return $this->value() === $other->value();

    }

    /**
     * ### Checks if the condition is met and throws an exception otherwise
     * @since 1.0.0
     *
     * @param callable():bool $condition <p>
     * Condition to check.
     * </p>
     * @param string $message <p>
     * Exception message.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\InvalidValueObjectError If the condition is not met.
     *
     * @return void
     */
    protected function guard (callable $condition, string $message):void {

        if ($condition() === true) throw new InvalidValueObjectError($message);

    }

}