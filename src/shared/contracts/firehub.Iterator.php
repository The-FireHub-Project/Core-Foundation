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
 */

namespace FireHub\Core\Shared\Contracts;

use Iterator as InternalIterator;

/**
 * ### Base iterator contract
 *
 * Interface for external iterators or objects that can be iterated themselves internally.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @extends Traversable<TKey, TValue>
 * @extends InternalIterator<TKey, TValue>
 */
interface Iterator extends Traversable, InternalIterator {

    /**
     * ### Checks if the current position is valid
     * @since 1.0.0
     *
     * @return bool True on success or false on failure.
     *
     * @note This method is called after rewind() and next() to check if the current position is valid.
     */
    public function valid ():bool;

    /**
     * ### Return the current element
     * @since 1.0.0
     *
     * @return TValue Current element.
     */
    public function current ():mixed;

    /**
     * ### Return the key of the current element
     * @since 1.0.0
     *
     * @return null|TKey Key of the current element.
     */
    public function key ():mixed;

    /**
     * ### Move forward to the next element
     * @since 1.0.0
     *
     * @return void
     *
     * @note This method is called after each foreach loop.
     */
    public function next ():void;

    /**
     * ### Rewind the iterator to the first element
     * @since 1.0.0
     *
     * @return void
     *
     * @note This is the first method called when starting a foreach loop.
     * It will not be executed after foreach loops.
     */
    public function rewind ():void;

}