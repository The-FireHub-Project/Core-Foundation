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
 * ### Provide explicit deep copy of a storage
 *
 * Defines a contract for creating a full, independent copy of a storage by duplicating all underlying data. The
 * resulting instance has no shared state with the original, ensuring complete isolation at the cost of O(n) time and
 * memory complexity. Suitable for scenarios where data integrity and independence are required over performance
 * optimizations.
 * @since 1.0.0
 */
interface Cloneable {

    /**
     * ### Create a full independent deep copy of the storage
     *
     * Creates a completely independent clone of the storage by duplicating all internal data. The resulting instance
     * shares no state with the original, ensuring full isolation between both objects. This operation has O(n) time
     * and memory complexity and is suitable when data integrity and strict independence are required over performance
     * optimization.
     * @since 1.0.0
     *
     * @return static A deep copy of the storage.
     */
    public function copy ():static;

}