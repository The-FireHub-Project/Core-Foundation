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
 */

namespace FireHub\Core\Support\DataStructure\Abstract;

use FireHub\Core\Support\DataStructure\Contracts\Collection;
use FireHub\Core\Support\DataStructure\Contracts\Capability\Transformable;
use FireHub\Core\Shared\Contracts\ {
    Magic\SerializableConvertable, ArrayConvertable, JsonSerializableConvertable
};
use FireHub\Core\Support\DataStructure\Traits\ {
    Convertable, Enumerable, Shared
};
use Traversable;

/**
 * ### Abstract Array-Backed Collection Base
 *
 * Provides a base implementation for collections backed by a native array storage. It defines the core behavior for
 * iteration, internal storage handling, and shared collection operations, while leaving concrete instantiation
 * details to child classes.
 *
 * This abstract class serves as the foundational layer for array-based data structures within the FireHub ecosystem,
 * enabling consistent behavior across derived implementations such as lists, maps, and specialized collections.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \FireHub\Core\Support\DataStructure\Contracts\Collection<TKey, TValue>
 * @implements \FireHub\Core\Shared\Contracts\ArrayConvertable<TKey, TValue>
 * @implements \FireHub\Core\Shared\Contracts\JsonSerializableConvertable<TKey, TValue>
 * @implements \FireHub\Core\Shared\Contracts\Magic\SerializableConvertable<TKey, TValue>
 * @implements \FireHub\Core\Support\DataStructure\Contracts\Capability\Transformable<TKey, TValue>
 *
 * @phpstan-consistent-constructor
 */
abstract class ArrayCollection implements Collection, ArrayConvertable, JsonSerializableConvertable,
    SerializableConvertable, Transformable {

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
     * use FireHub\Core\Support\DataStructures\ArrayCollection;
     *
     * $collection = new ArrayCollection(['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]);
     *
     * $collection->toArray();
     *
     * // ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]
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
    public function map (callable $callback):static {

        $storage = [];

        foreach ($this->storage as $key => $value) $storage[$key] = $callback($value, $key);

        return new static($storage);

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