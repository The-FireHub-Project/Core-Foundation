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

namespace FireHub\Core\Support\DataStructure\Collection\Linear;

use FireHub\Core\Support\DataStructure\Abstraction\Collection;
use FireHub\Core\Support\DataStructure\Type\Linear;
use FireHub\Core\Support\DataStructure\Capability\ {
    Access\SequentialAccess, Behavior\Countable
};
use FireHub\Core\Support\DataStructure\Storage;
use FireHub\Core\Support\DataStructure\Trait\EnumerableBehavior;
use Traversable;

/**
 * ### Sequence Data Structure
 *
 * A fundamental linear structure that maintains a strict ordering of elements. Provides predictable iteration, stable
 * indexing (depending on storage), and serves as a base abstraction for other linear collections.
 * @since 1.0.0
 *
 * @template TValue
 *
 * @implements \FireHub\Core\Support\DataStructure\Abstraction\Collection<int, TValue>
 *
 * @phpstan-type StorageType = (\FireHub\Core\Support\DataStructure\Storage<int, TValue>&\FireHub\Core\Support\DataStructure\Capability\Access\SequentialAccess)
 */
class Sequence implements Collection, Linear, Countable {

    /**
     * ### Enumerable Behavior Trait
     * @since 1.0.0
     *
     * @use \FireHub\Core\Support\DataStructure\Trait\EnumerableBehavior<int, TValue>
     */
    use EnumerableBehavior;

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage As parameter.
     *
     * @param StorageType $storage <p>
     * Underlying storage data.
     * </p>
     *
     * @return void
     */
    public function __construct (
        protected Storage&SequentialAccess $storage
    ) {}

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructure\DS;
     *
     * $ds = DS::sequence()->fromArray(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $ds->count();
     *
     * // 6
     * </code>
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage::count() To count the number of elements in the sequence.
     */
    public function count ():int {

        return $this->storage->count();

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage::entries() To get the entries of the storage for iteration.
     */
    public function getIterator ():Traversable {

        yield from $this->storage->entries();

    }

}