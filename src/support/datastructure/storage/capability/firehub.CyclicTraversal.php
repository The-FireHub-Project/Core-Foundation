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

namespace FireHub\Core\Support\DataStructure\Storage\Capability;

/**
 * ### Cyclic Traversal Capability
 *
 * Provides the ability to traverse a data structure in a continuous infinite loop. This capability is intended for
 * cyclic or circular data structures where iteration does not terminate naturally and instead restarts from the
 * beginning upon reaching the end.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
interface CyclicTraversal {

    /**
     * ### Cycle through elements infinitely
     *
     * Returns an infinite iterable sequence that continuously traverses the structure in a loop, restarting from the
     * beginning once the end is reached.
     * @since 1.0.0
     *
     * @param null|int $limit <p>
     * Maximum number of elements to yield. If null, traversal is infinite.
     * </p>
     *
     * @return iterable<TKey, TValue> Infinite cyclic traversal of elements.
     *
     * @warning This method does not terminate naturally and must be consumed with care
     * (e.g. with limits or external stopping conditions).
     */
    public function cycle (?int $limit = null):iterable;

}