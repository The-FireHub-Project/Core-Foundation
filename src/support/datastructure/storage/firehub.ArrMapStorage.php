<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.0
 * @package Core\Support
 */

namespace FireHub\Core\Support\DataStructure\Storage;

use FireHub\Core\Support\DataStructure\Storage;
use FireHub\Core\Support\DataStructure\Storage\Initialization\ArrStorageInitializer;
use FireHub\Core\Support\DataStructure\Storage\Capability\ {
    Cloneable, KeyAccess, KeyMutation, StorageMetricsAware
};
use FireHub\Core\Shared\Type\Maybe;
use FireHub\Core\Shared\Enums\MutationOutcome;
use FireHub\Core\Support\LowLevel\Arr;

/**
 * ### Array-Based Map Storage
 *
 * A mutable key-value storage implementation backed by a native PHP associative array. Provides fast key-based
 * access, insertion, and mutation while preserving insertion order. Designed for structured datasets where elements
 * are accessed via unique keys rather than positional indexing. Optimized for configuration objects, registries,
 * and general-purpose associative collections with predictable lookup performance.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \FireHub\Core\Support\DataStructure\Storage<TKey, TValue>
 * @implements \FireHub\Core\Support\DataStructure\Storage\Capability\KeyAccess<TKey, TValue>
 * @implements \FireHub\Core\Support\DataStructure\Storage\Capability\KeyMutation<TKey, TValue>
 */
final class ArrMapStorage implements Storage, Cloneable, StorageMetricsAware, KeyAccess, KeyMutation {

    /**
     * ### Underlying data storage
     * @since 1.0.0
     *
     * @var array<TKey, TValue>
     */
    private array $data = [];

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\Initialization\ArrStorageInitializer As parameter.
     *
     * @param null|\FireHub\Core\Support\DataStructure\Storage\Initialization\ArrStorageInitializer<TKey, TValue> $initializer [optional] <p>
     * Initial data to store.
     * </p>
     *
     * @return void
     */
    public function __construct (?ArrStorageInitializer $initializer = null) {

        if ($initializer !== null) $this->data = $initializer();

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function iterate ():iterable {

        return $this->data;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function copy ():static {

        $clone = new static();

        $clone->data = [];

        foreach ($this->data as $key => $value)
            $clone->data[$key] = $value;

        /** @var static<TKey, TValue> */
        return $clone;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function capacity ():null {

        return null;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function availableCapacity ():null {

        return null;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::count() To count the number of elements in the storage.
     */
    public function size ():int {

        return Arr::count($this->data);

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::keyExists() To check if a key exists in the storage.
     */
    public function has (int|string $key):bool {

        return Arr::keyExists($key, $this->data);

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\ArrMapStorage::has() To check if key exists.
     */
    public function get (int|string $key):Maybe {

        return $this->has($key)
            ? Maybe::some($this->data[$key]) // @phpstan-ignore offsetAccess.notFound
            : Maybe::none();

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\ArrListStorage::has() To check if index exists.
     */
    public function set (int|string $key, mixed $value):MutationOutcome {

        $this->data[$key] = $value;

        return $this->has($key)
            ? MutationOutcome::UPDATED
            : MutationOutcome::CREATED;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\ArrListStorage::has() To check if index exists.
     */
    public function remove (int|string $key):MutationOutcome {

        unset($this->data[$key]);

        return $this->has($key)
            ? MutationOutcome::REMOVED
            : MutationOutcome::NOT_FOUND;

    }

}