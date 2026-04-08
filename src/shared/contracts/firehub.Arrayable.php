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
 * ### Represents an object that can be converted into an array representation
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 */
interface Arrayable {

    /**
     * ### Convert object to array
     * @since 1.0.0
     *
     * @return array<TKey, TValue> Object as an array.
     */
    public function toArray ():array;

}