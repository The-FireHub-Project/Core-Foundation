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

use FireHub\Core\Support\DataStructure\Contracts\Collection as CollectionContract;
use FireHub\Core\Shared\Contracts\ {
    Magic\SerializableConvertable, ArrayConvertable, JsonSerializableConvertable
};
use FireHub\Core\Support\DataStructure\Traits\ {
    Convertable, Enumerable, Shared
};
use Traversable;

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
 * @implements \FireHub\Core\Support\DataStructure\Contracts\Collection<TKey, TValue>
 * @implements \FireHub\Core\Shared\Contracts\ArrayConvertable<TKey, TValue>
 * @implements \FireHub\Core\Shared\Contracts\JsonSerializableConvertable<TKey, TValue>
 * @implements \FireHub\Core\Shared\Contracts\Magic\SerializableConvertable<TKey, TValue>
 *
 * @phpstan-consistent-constructor
 */
class Collection implements CollectionContract, ArrayConvertable, JsonSerializableConvertable, SerializableConvertable {

    /**
     * ### Shared Operations for All Data Structures
     * @since 1.0.0
     *
     * @use \FireHub\Core\Support\DataStructure\Traits\Shared<TKey, TValue>
     */
    use Shared;

    /**
     * ### Enumerable – Shared Iteration and Transformation Behavior
     * @since 1.0.0
     *
     * @use \FireHub\Core\Support\DataStructure\Traits\Enumerable<TKey, TValue>
     */
    use Enumerable;

    /**
     * ### Convertable Trait
     * @since 1.0.0
     *
     * @use \FireHub\Core\Support\DataStructure\Traits\Convertable<TKey, TValue>
     */
    use Convertable;

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
    public function __construct (
        protected(set) array $storage = []
    ) {}

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

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructures\Collection;
     *
     * $collection = new Collection(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $collection->toArray();
     *
     * // ['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']
     * </code>
     *
     * @since 1.0.0
     */
    public function toArray ():array {

        return $this->storage;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function jsonSerialize ():array {

        return $this->storage;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function getIterator ():Traversable {

        yield from $this->storage;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @return array<TKey, TValue> An associative array of key/value pairs that represent the serialized form
     * of the object.
     */
    public function __serialize ():array {

        return $this->storage;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @param array<TKey, TValue> $data <p>
     * Serialized data.
     * </p>
     */
    public function __unserialize (array $data):void {

        $this->storage = $data;

    }

}