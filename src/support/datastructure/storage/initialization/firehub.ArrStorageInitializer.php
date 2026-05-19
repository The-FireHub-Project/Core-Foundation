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

namespace FireHub\Core\Support\DataStructure\Storage\Initialization;

/**
 * ### Array Storage Initializer
 *
 * Provides a strategy for initializing the internal array of an ArrStorage instance during construction. Enables
 * controlled, potentially lazy, or computed population of the underlying data structure while preserving encapsulation
 * and avoiding direct array injection. Suitable for large datasets, dynamic generation, or deferred materialization
 * patterns.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 */
interface ArrStorageInitializer {

    /**
     * ### Invoke Initializer
     * @since 1.0.0
     *
     * @return array<TKey, TValue> Underlying data for storage.
     */
    public function __invoke ():array;

}