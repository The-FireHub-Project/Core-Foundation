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
 * ### Post-Node Insertion Capability
 *
 * Defines the ability to insert a node directly after a given target node within a pointer-based storage structure.
 * This operation assumes the existence of forward-linking topology and is typically O(1) in singly, doubly, and
 * circular linked structures.
 * @since 1.0.0
 *
 * @template TValue
 */
interface NodeInsertAfter {

    /**
     * ### Insert a node after a target node
     *
     * Inserts a new node immediately after the specified target node, updating internal links to maintain structural
     * consistency. Operates in O(1) for linked implementations where node references are directly accessible.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle As parameter and return.
     *
     * @param \FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle<TValue> $target <p>
     * The node after which the new node will be inserted.
     * </p>
     * @param TValue $value <p>
     * The value to be inserted.
     * </p>
     *
     * @return \FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle<TValue> New node handle.
     */
    public function insertAfter (NodeHandle $target, mixed $value):NodeHandle;

}