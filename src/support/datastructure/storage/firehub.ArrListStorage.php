<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.4
 * @package Core\Support
 */

namespace FireHub\Core\Support\DataStructure\Storage;

use FireHub\Core\Support\DataStructure\Storage;
use FireHub\Core\Support\DataStructure\Storage\Initialization\ArrStorageInitializer;
use FireHub\Core\Support\DataStructure\Storage\Capability\ {
    Cloneable, DequeMutation, IndexAccess, IndexMutation, LinearBoundaryAccess, StorageMetricsAware
};
use FireHub\Core\Shared\Type\Maybe;
use FireHub\Core\Shared\Enums\MutationOutcome;
use FireHub\Core\Support\LowLevel\ {
    Arr, Math
};

/**
 * ### Array-Based List Storage
 *
 * A mutable sequential storage implementation backed by a native array structure. Represents an ordered list of
 * elements with integer-indexed access and preserves insertion order. Supports fast append operations, indexed
 * mutation, and controlled front and back insertions/removals with predictable performance characteristics. Designed
 * for general-purpose list-based collections where ordered iteration and positional access are primary requirements.
 * @since 1.0.0
 *
 * @template TValue
 *
 * @implements \FireHub\Core\Support\DataStructure\Storage<int, TValue>
 * @implements \FireHub\Core\Support\DataStructure\Storage\Capability\LinearBoundaryAccess<TValue>
 * @implements \FireHub\Core\Support\DataStructure\Storage\Capability\DequeMutation<TValue>
 * @implements \FireHub\Core\Support\DataStructure\Storage\Capability\IndexAccess<TValue>
 * @implements \FireHub\Core\Support\DataStructure\Storage\Capability\IndexMutation<TValue>
 */
final class ArrListStorage implements Storage, Cloneable, StorageMetricsAware, LinearBoundaryAccess, DequeMutation,
    IndexAccess, IndexMutation {

    /**
     * ### Underlying data storage
     * @since 1.0.0
     *
     * @var array<TValue>
     */
    private array $data = [];

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\Initialization\ArrStorageInitializer As parameter.
     * @uses \FireHub\Core\Support\LowLevel\Arr::values() To convert the array keys to integers.
     *
     * @param null|\FireHub\Core\Support\DataStructure\Storage\Initialization\ArrStorageInitializer<int, TValue> $initializer [optional] <p>
     * Initial data to store.
     * </p>
     *
     * @return void
     */
    public function __construct (?ArrStorageInitializer $initializer = null) {

        if ($initializer !== null) $this->data = Arr::values($initializer());

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function iterate ():iterable {

        /** @var array<int, TValue> */
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

        foreach ($this->data as $value)
            $clone->data[] = $value;

        /** @var static<TValue> */
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
     * @uses \FireHub\Core\Support\LowLevel\Arr::first() To get the first element in the storage.
     */
    public function first ():Maybe {

        if ($this->data === []) return Maybe::none();

        /** @var TValue $first */
        $first = Arr::first($this->data);

        return Maybe::some($first);

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::last() To get the last element in the storage.
     */
    public function last ():Maybe {

        if ($this->data === []) return Maybe::none();

        /** @var TValue $last */
        $last = Arr::last($this->data);

        return Maybe::some($last);

    }

    /**
     * @inheritDoc
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::unshift() To prepend values to the beginning of the array.
     *
     * @since 1.0.0
     */
    public function addFirst (mixed ...$values):static {

        Arr::unshift($this->data, ...$values);

        return $this;

    }

    /**
     * @inheritDoc
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::push() To append values to the end of the array.
     *
     * @since 1.0.0
     */
    public function addLast (mixed ...$values):static {

        Arr::push($this->data, ...$values);

        return $this;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::slice() To remove first items from the array.
     * @uses \FireHub\Core\Support\LowLevel\Math::max() To ensure the number of items to remove is not negative.
     */
    public function removeFirst (int $items = 1):static {

        $this->data = Arr::slice($this->data, Math::max($items, 0));

        return $this;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::pop() To remove last items from the array.
     */
    public function removeLast (int $items = 1):static {

        while ($items-- > 0)
            Arr::pop($this->data);

        return $this;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::keyExists() To check if a key exists in the storage.
     */
    public function has (int $index):bool {

        return Arr::keyExists($index, $this->data);

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\ArrListStorage::has() To check if index exists.
     */
    public function get (int $index):Maybe {

        return $this->has($index)
            ? Maybe::some($this->data[$index]) // @phpstan-ignore offsetAccess.notFound
            : Maybe::none();

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\ArrListStorage::has() To check if index exists.
     */
    public function set (int $index, mixed $value):MutationOutcome {

        $this->data[$index] = $value;

        return $this->has($index)
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
    public function remove (int $index):MutationOutcome {

        unset($this->data[$index]);

        return $this->has($index)
            ? MutationOutcome::REMOVED
            : MutationOutcome::NOT_FOUND;

    }

}