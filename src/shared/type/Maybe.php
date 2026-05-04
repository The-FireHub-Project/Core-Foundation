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
 */

namespace FireHub\Core\Shared\Type;

use FireHub\Core\Throwable\Exception\Shared\Type\NoValueException;

/**
 * ### Optional Value Container (Maybe Type)
 *
 * Represents a computation result that may or may not contain a value.<br>
 * This abstraction explicitly encodes the presence or absence of a value, removing ambiguity between "null as
 * value" and "null as state".
 *
 * The Maybe type is used as a safe alternative to nullable returns in Storage, Data Structure, and Application
 * layers where value existence must be explicitly expressed.
 * @since 1.0.0
 *
 * @template TValue
 */
final readonly class Maybe {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param bool $hasValue <p>
     * Indicates whether a value is present.
     * </p>
     * @param null|TValue $value [optional] <p>
     * Optional stored value (can be null if explicitly set via `some()`).
     * </p>
     *
     * @return void
     */
    private function __construct(
        private bool $hasValue,
        private mixed $value = null
    ) {}

    /**
     * ### Create an Empty Maybe Instance
     *
     * Creates a Maybe instance representing the absence of a value.
     * This state explicitly indicates that no value is present and is distinct from a null value.
     * @since 1.0.0
     *
     * @return self<null> Empty Maybe instance.
     */
    public static function none ():self {

        return new self(false);

    }

    /**
     * ### Create a Maybe Instance With a Value
     *
     * Wraps a value into a Maybe container, explicitly marking it as present.<br>
     * The value may be null, but will still be considered a valid present state.
     * @since 1.0.0
     *
     * @template TSomeValue
     *
     * @param TSomeValue $value <p>
     * The value to wrap.
     * </p>
     *
     * @return self<TSomeValue> Maybe instance containing a value.
     */
    public static function some (mixed $value):self {

        return new self(true, $value);

    }

    /**
     * ### Check Value Presence
     *
     * Determines whether this Maybe instance contains a value.<br>
     * Returns true even if the stored value is null, as presence is independent of value content.
     * @since 1.0.0
     *
     * @return bool True if a value is present, false otherwise.
     */
    public function has ():bool {

        return $this->hasValue;

    }

    /**
     * ### Check Value Absence
     *
     * Determines whether this Maybe instance does not contain a value.<br>
     * This is the inverse of `has()`.
     * @since 1.0.0
     *
     * @return bool True if no value is present, false otherwise.
     */
    public function isEmpty ():bool {

        return !$this->hasValue;

    }

    /**
     * ### Retrieve Wrapped Value
     *
     * Returns the stored value if present.<br>
     * Throws an exception if no value exists in this Maybe instance.
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Throwable\Exception\Shared\Type\NoValueException If no value is present.
     *
     * @return TValue The wrapped value.
     */
    public function get ():mixed {

        if (!$this->hasValue) throw new NoValueException;

        /** @var TValue */
        return $this->value;

    }

    /**
     * ### Unwrap Value or Default
     *
     * Returns the wrapped value if present, otherwise returns the provided default value.<br>
     * This method provides a safe fallback mechanism for empty Maybe instances.
     * @since 1.0.0
     *
     * @template TDefault
     *
     * @param TDefault $default <p>
     * Default value returned if Maybe is empty.
     * </p>
     *
     * @return TValue|TDefault The stored value or the default.
     */
    public function unwrap (mixed $default):mixed {

        return $this->hasValue ? $this->value : $default; // @phpstan-ignore return.type

    }

}