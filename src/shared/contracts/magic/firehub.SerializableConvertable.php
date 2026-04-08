<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.0
 * @package Core\Shared
 */

namespace FireHub\Core\Shared\Contracts\Magic;

/**
 * ### Serializable-convertable object that can be serialized and unserialized
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @extends \FireHub\Core\Shared\Contracts\Magic\Serializable<TKey, TValue>
 */
interface SerializableConvertable extends Serializable {

    /**
     * ### Creates an object from a stored representation
     * @since 1.0.0
     *
     * @param non-empty-string $data <p>
     * The serialized string.
     * </p>
     * @param positive-int $max_depth [optional] <p>
     * The maximum depth of structures is permitted during unserialization and is intended to prevent stack overflows.
     * </p>
     *
     * @return static Object from a serialized parameter.
     */
    public static function unserialize (string $data, int $max_depth = 4096):static;

    /**
     * ### Converts from serialized data back to the object
     * @since 1.0.0
     *
     * @param array<TKey, TValue> $data <p>
     * Serialized data.
     * </p>
     *
     * @return void
     */
    public function __unserialize (array $data):void;

}