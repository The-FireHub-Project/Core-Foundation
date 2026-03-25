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
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\DataStructure\Traits;

use FireHub\Core\Support\LowLevel\Iterator;

/**
 * ### Shared Operations for All Data Structures
 *
 * A reusable trait providing common methods for all data structures, including element counting, emptiness checks,
 * key/value access, iteration, and conversion from other data structures. Designed to standardize shared behavior
 * across both linear and non-linear collections while minimizing code duplication.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
trait Shared {

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructures\Collection;
     *
     * $collection = new Collection(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $collection->count();
     *
     * // 6
     * </code>
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Iterator::count() To count storage items.
     */
    public function count ():int {

        return Iterator::count($this);

    }

}