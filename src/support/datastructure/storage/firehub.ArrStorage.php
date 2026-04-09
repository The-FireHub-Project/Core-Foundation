<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core\Support
 */

namespace FireHub\Core\Support\DataStructure\Storage;

use FireHub\Core\Support\DataStructure\Storage;
use FireHub\Core\Support\LowLevel\Arr;
use Traversable;

/**
 * ### Array-Based Storage
 *
 * In-memory storage implementation based on contiguous array structures. Provides fast sequential and random access
 * with predictable performance characteristics.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \FireHub\Core\Support\DataStructure\Storage<TKey, TValue>
 */
class ArrStorage implements Storage {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param array<TKey, TValue> $data <p>
     * Initial data to store.
     * </p>
     *
     * @return void
     */
    public function __construct (
        protected array $data = []
    ) {}

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::count() To count the number of elements in the array.
     */
    public function count ():int {

        return Arr::count($this->data);

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function getIterator ():Traversable {

        yield from $this->data;

    }

}