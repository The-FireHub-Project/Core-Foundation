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
 * ### Node Handle Access Capability
 *
 * Defines a read-only capability for accessing structural positions within a node-based storage system through
 * NodeHandle references. It provides safe entry points into the internal topology without exposing raw nodes or
 * traversal logic. This interface is intended exclusively for storage implementations that are based on explicit node
 * structures such as linked lists, trees, or graph-like systems.
 * @since 1.0.0
 *
 * @template TValue
 */
interface NodeAccess {

    /**
     * ### Retrieve First Node Handle
     *
     * Returns a NodeHandle representing the first logical element in the storage structure. The definition of
     * “first” depends on the underlying topology (e.g. head in linked lists or root-like entry in hierarchical
     * structures). Returns null if the structure is empty.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle As return.
     *
     * @return null|\FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle<TValue> NodeHandle with value at the
     * first position in the storage, or null if the structure is empty.
     */
    public function firstNode ():?NodeHandle;

    /**
     * ### Retrieve Last Node Handle
     *
     * Returns a NodeHandle representing the last logical element in the storage structure. Applicable primarily to
     * ordered or linear node-based structures such as linked lists or deque-based implementations. Returns null if the
     * structure is empty.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle As return.
     *
     * @return null|\FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle<TValue> NodeHandle with value at the
     * last position in the storage, or null if the structure is empty.
     */
    public function lastNode ():?NodeHandle;


}