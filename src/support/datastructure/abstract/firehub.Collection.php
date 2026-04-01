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

namespace FireHub\Core\Support\DataStructure\Abstract;

use FireHub\Core\Support\DataStructure\Contracts\Collection as CollectionContract;
use FireHub\Core\Shared\Contracts\ {
    Magic\SerializableConvertable, ArrayConvertable, JsonSerializableConvertable
};
use FireHub\Core\Support\DataStructure\Traits\ {
    Convertable, Enumerable, Shared
};
use Traversable;

/**
 * ### Abstract collection base
 *
 * Serves as the foundational implementation for all high-level collection types within the FireHub framework.<br>
 * Defines shared behavior such as iteration, reduction, and transformation while delegating structural rules and
 * constraints to concrete implementations.
 *
 * Enables extensibility and consistency across generic and specialized data structures without imposing specific key
 * or value semantics.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \FireHub\Core\Support\DataStructure\Contracts\Collection<TKey, TValue>
 * @implements \FireHub\Core\Shared\Contracts\ArrayConvertable<TKey, TValue>
 * @implements \FireHub\Core\Shared\Contracts\JsonSerializableConvertable<TKey, TValue>
 * @implements \FireHub\Core\Shared\Contracts\Magic\SerializableConvertable<TKey, TValue>
 */
abstract class Collection implements CollectionContract, ArrayConvertable, JsonSerializableConvertable, SerializableConvertable {

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
    abstract public static function fromArray (array $array):static;

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