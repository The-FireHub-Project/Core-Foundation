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

namespace FireHub\Core\Support\DataStructure\Linear;

use FireHub\Core\Support\DataStructure\ {
    Linear, Storage
};
use FireHub\Core\Support\DataStructure\Behavior\ {
    Countable, Enumerable
};
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
 * @implements \FireHub\Core\Support\DataStructure\Linear<TValue>
 * @implements \FireHub\Core\Support\DataStructure\Behavior\Enumerable<mixed, TValue>
 */
class Sequence implements Linear, Countable, Enumerable {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage As parameter.
     *
     * @param \FireHub\Core\Support\DataStructure\Storage<mixed, TValue> $storage <p>
     * Underlying storage data.
     * </p>
     *
     * @return void
     */
    public function __construct (
        protected Storage $storage
    ) {}

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructure\Linear\Sequence;
     * use FireHub\Core\Support\DataStructure\Storage\ArrStorage;
     *
     * $collection = new Sequence(new ArrStorage(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']));
     *
     * // ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]
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
     */
    public function getIterator ():Traversable {

        return $this->storage;

    }

}