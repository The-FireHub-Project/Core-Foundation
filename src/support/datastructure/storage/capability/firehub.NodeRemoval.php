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
 * ### Node Removal Capability
 *
 * Defines the ability to remove a specific node from a storage structure by directly manipulating its surrounding
 * links. This operation is pointer-based and allows O(1) removal in structures that maintain direct references to
 * adjacent nodes.
 * @since 1.0.0
 *
 * @template TValue
 */
interface NodeRemoval {

    /**
     * ### Remove Node from storage
     *
     * Removes the specified node from the storage structure and reconnects surrounding nodes to preserve continuity.
     * Complexity depends on a structure type (O(1) for doubly-linked with direct reference, O(n) for singly-linked
     * traversal-based removal).
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle As parameter.
     *
     * @param \FireHub\Core\Support\DataStructure\Storage\Handle\NodeHandle<TValue> $handle <p>
     * The node to remove.
     * </p>
     *
     * @return static The modified storage structure.
     */
    public function removeNode (NodeHandle $handle):static;

}