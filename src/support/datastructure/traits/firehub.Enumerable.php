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
 * ### Enumerable – Shared Iteration and Transformation Behavior
 *
 * Provides a reusable implementation of common iteration and transformation methods for data structures.
 * This trait includes high-level operations, allowing consistent element-wise processing across different
 * implementations.<br>
 * It is designed to be used by data structures that expose sequential access to their elements (e.g., Collection,
 * LazyCollection), reducing duplication and ensuring a uniform API without enforcing a strict contract.
 * @since 1.0.0
 *
 * @template-covariant TKey
 * @template-covariant TValue
 */
trait Enumerable {

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