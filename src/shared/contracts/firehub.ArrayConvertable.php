<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core\Shared
 */

namespace FireHub\Core\Shared\Contracts;

/**
 * ### ArrayConstructable interface
 *
 * Objects that can be created from arrays and can convert themselves to arrays.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @extends \FireHub\Core\Shared\Contracts\Arrayable<TKey, TValue>
 */
interface ArrayConvertable extends Arrayable {

    /**
     * ### Create a new object from an array
     *
     * This static method constructs a new instance of the implementing class using the provided array as its initial
     * data storage.
     * @since 1.0.0
     *
     * @param array<TKey, TValue> $array <p>
     * Input data for creating the object.
     * </p>
     *
     * @return static A new instance of the implementing class.
     */
    public static function fromArray (array $array):static;

}