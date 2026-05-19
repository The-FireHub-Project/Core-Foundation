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

namespace FireHub\Core\Support\DataStructure;

/**
 * ### Storage Abstraction Layer
 *
 * Root contract for all storage implementations in the system.<br>
 * A Storage represents a persistence boundary responsible for holding, exposing, and iterating over data entries
 * through a unified access model. It abstracts away the underlying memory or structural representation, ensuring that
 * all implementations provide a consistent entry-based interface for consumption by Data Structures.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
interface Storage {

    /**
     * ### Traverses Storage Elements
     *
     * Provides a unified, read-only traversal contract for accessing all elements within a storage implementation.
     * The method exposes elements in their natural iteration order without leaking internal structure details or
     * coupling the consumer to a specific storage strategy.
     * Each storage implementation defines its own traversal mechanism, but all must guarantee compliance with
     * the iterable contract and ensure safe, side-effect-free iteration over the current state.
     * @since 1.0.0
     *
     * @return iterable<TKey, TValue>
     */
    public function iterate ():iterable;

}