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

use FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle;

/**
 * ### Pre-Node Insertion Capability
 *
 * Defines the ability to insert a node directly before a given target node. This operation requires backward
 * navigation or traversal support and is naturally supported in doubly linked structures, while potentially O(n) in
 * singly linked implementations.
 * @since 1.0.0
 *
 * @template TValue
 */
interface NodeInsertBefore {

    /**
     * ### Insert a node before a target node
     *
     * Inserts a new node immediately before the specified target node. Requires traversal in singly linked
     * structures but operates in O(1) for doubly linked implementations where backward references are available.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle As parameter and return.
     *
     * @param \FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle<TValue> $target <p>
     * The node before which the new node will be inserted.
     * </p>
     * @param TValue $value <p>
     * The value to be inserted.
     * </p>
     *
     * @return \FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle<TValue> New node handle.
     */
    public function insertBefore (NodeHandle $target, mixed $value):NodeHandle;

}