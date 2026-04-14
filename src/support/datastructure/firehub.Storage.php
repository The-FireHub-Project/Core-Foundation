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
 * Root contract for all storage implementations in the system. Defines the base rules for how data is persisted,
 * accessed, and managed regardless of the underlying memory model (array, linked, generator, or external source).
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
interface Storage {

    /**
     * ### Get all entries from the storage
     * @since 1.0.0
     *
     * @return iterable<TKey, TValue>
     */
    public function entries ():iterable;

    /**
     * ### Get all keys from the storage
     * @since 1.0.0
     *
     * @return iterable<int, TKey>
     */
    public function keys ():iterable;

    /**
     * ### Get all values from the storage
     * @since 1.0.0
     *
     * @return iterable<int, TValue>
     */
    public function values ():iterable;

}