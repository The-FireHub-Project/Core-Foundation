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

namespace FireHub\Core\Support\DataStructure\Storage\Capability;

/**
 * ### Storage Metrics Awareness Contract
 *
 * A unified interface that defines standardized introspection capabilities for storage structures.<br>
 * It provides a consistent way to access structural metrics such as the number of active elements and the maximum
 * storage capacity across all FireHub data structure implementations.<br>
 *This contract ensures uniform observability for both bounded and unbounded storage types, enabling generic
 * algorithms, diagnostics, and performance-aware operations to interact with different storage implementations
 * without knowledge of their internal representation.<br>
 * It serves as a core abstraction layer for monitoring storage state, supporting operations such as utilization
 * analysis, capacity planning, and runtime optimization decisions.
 * @since 1.0.0
 */
interface StorageMetricsAware {

    /**
     * ### Retrieve the maximum number of elements that can be stored in the storage
     * @since 1.0.0
     *
     * @return null|non-negative-int The maximum number of elements that can be stored in the storage, or null for
     * unbounded storage.
     */
    public function capacity ():?int;

    /**
     * ### Retrieve the remaining capacity that can be used in the storage
     *
     * @since 1.0.0
     *
     * @return null|non-negative-int The remaining capacity that can be used in the storage, or null for unbounded
     * storage.
     */
    public function availableCapacity ():?int;

    /**
     * ### Retrieve the number of elements stored in the storage
     * @since 1.0.0
     *
     * @return non-negative-int The number of elements stored in the storage.
     */
    public function size ():int;

}