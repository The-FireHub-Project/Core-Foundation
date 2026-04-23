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
 * ### Serializable contract
 *
 * Contract allows serialization for objects.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 */
interface Serializable {

    /**
     * ### Generates storable representation of an object
     * @since 1.0.0
     *
     * @return string String containing a byte-stream representation of an object that can be stored anywhere.
     */
    public function serialize ():string;

    /**
     * ### Construct and return an associative array of key/value pairs that represent the serialized form of the object
     * @since 1.0.0
     *
     * @return array<TKey, TValue> An associative array of key/value pairs that represent the serialized form
     * of the object.
     */
    public function __serialize ():array;

}