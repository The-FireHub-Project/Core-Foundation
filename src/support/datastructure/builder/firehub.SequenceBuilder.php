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

namespace FireHub\Core\Support\DataStructure\Builder;

use FireHub\Core\Support\DataStructure\Collection\Linear\Sequence;
use FireHub\Core\Support\DataStructure\Capability\Access\SequentialAccess;
use FireHub\Core\Support\DataStructure\ {
    Storage, Storage\ArrStorage
};
use FireHub\Core\Support\LowLevel\Arr;

/**
 * ### Sequence Builder
 *
 * Provides a scoped construction API for creating Sequence data structures.<br>
 * Handles normalization and storage selection while keeping the Sequence model clean.
 * @since 1.0.0
 */
final class SequenceBuilder {

    /**
     * ### Create Sequence from storage
     *
     * Uses an existing storage implementation that supports sequential access.
     * @since 1.0.0
     *
     * @template TValue
     *
     * @param \FireHub\Core\Support\DataStructure\Storage<int, TValue>&\FireHub\Core\Support\DataStructure\Capability\Access\SequentialAccess $storage <p>
     * Storage instance that provides sequential access to the data.
     * </p>
     *
     * @return Sequence<TValue> New Sequence instance.
     */
    public function fromStorage (Storage&SequentialAccess $storage):Sequence {

        return new Sequence($storage);

    }


    /**
     * ### Create Sequence from an array
     * Normalizes array keys into a sequential integer index.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::values() To reindex the input array with sequential integer keys.
     *
     * @template TValue
     *
     * @param array<array-key, TValue> $array <p>
     * The array to convert into a Sequence.
     * </p>
     *
     * @return Sequence<TValue> New Sequence instance.
     */
    public function fromArray (array $array):Sequence {

        return new Sequence(
            new ArrStorage(Arr::values($array))
        );

    }

    /**
     * ### Create Sequence from values
     * Builds a Sequence directly from given values without additional normalization.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::values() To reindex the input values with sequential integer keys.
     *
     * @template TValue
     *
     * @param TValue ...$values <p>
     * Variadic list of values to include in the Sequence.
     * </p>
     *
     * @return Sequence<TValue> New Sequence instance.
     */
    public function of (mixed ...$values):Sequence {

        return new Sequence(
            new ArrStorage(Arr::values($values))
        );

    }

}