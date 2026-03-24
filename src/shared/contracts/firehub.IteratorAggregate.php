<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core\Shared
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Shared\Contracts;

use IteratorAggregate as InternalIteratorAggregate, Traversable as InternalTraversable;

/**
 * ### Base iterator aggregate contract
 *
 * Interface for external iterators or objects that can be iterated themselves internally.
 * @since 1.0.0
 *
 * @template-covariant TKey
 * @template-covariant TValue
 *
 * @extends Traversable<TKey, TValue>
 * @extends InternalIteratorAggregate<TKey, TValue>
 */
interface IteratorAggregate extends Traversable, InternalIteratorAggregate {

    /**
     * ### Retrieve an external iterator
     * @since 1.0.0
     *
     * @return InternalTraversable<TKey, TValue> An instance of an object implementing Iterator or Traversable.
     */
    public function getIterator ():InternalTraversable;

}