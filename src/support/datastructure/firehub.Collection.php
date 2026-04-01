<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.4
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\DataStructure;

use FireHub\Core\Support\DataStructure\Abstract\Collection as AbstractCollection;

/**
 * ### Collection – High-level, Eager Array-based Data Structure
 *
 * Provides a concrete, high-level implementation of the DataStructure contract based on native PHP arrays.
 * The Collection operates using an eager evaluation model and offers a consistent, type-safe API for working with
 * in-memory array data, including iteration, transformation, and utility operations.
 * This implementation is intentionally designed as a general-purpose wrapper around arrays and does not aim to
 * represent or replace specialized data structures such as lazy collections, fixed-size arrays, or other advanced
 * structures. It serves as the foundational data container within FireHub Core Foundation.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @extends \FireHub\Core\Support\DataStructure\Abstract\Collection<TKey, TValue>
 */
class Collection extends AbstractCollection {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param array<TKey, TValue> $storage [optional] <p>
     * Underlying storage data.
     * </p>
     *
     * @retrun void
     */
    final public function __construct (
        array $storage = []
    ) {

        parent::__construct($storage);

    }

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructures\Collection;
     *
     * $collection = Collection::fromArray(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * // ['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']
     * </code>
     *
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * Input data for creating the object.
     * </p>
     *
     * @return static<key-of<TArray>, value-of<TArray>> A new instance of the implementing class.
     */
    public static function fromArray (array $array):static {

        return new static($array);

    }

}