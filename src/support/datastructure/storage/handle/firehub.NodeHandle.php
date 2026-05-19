<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.2
 * @package Core\Support
 */

namespace FireHub\Core\Support\DataStructure\Storage\Handle;

use FireHub\Core\Support\DataStructure\Storage\Node;

/**
 * ### Opaque Storage Node Handle
 *
 * A lightweight, immutable reference that uniquely identifies and encapsulates a node within a storage structure.
 * The handle acts as a stable external pointer to an internal node without exposing its implementation details or
 * allowing direct structural manipulation. It is bound to a specific storage instance and is intended to be used as a
 * safe token for node-based operations such as mutation, retrieval, or structural navigation through controlled APIs.
 * NodeHandle does not provide traversal capabilities and does not represent a cursor in the navigational sense.
 * Instead, it serves purely as an identity-safe bridge between external API consumers and internal storage topology.
 * @since 1.0.0
 *
 * @template TValue
 */
final readonly class NodeHandle {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param \FireHub\Core\Support\DataStructure\Storage\Node<TValue> $node <p>
     * The node to be encapsulated by the handle.
     * </p>
     *
     * @return void
     */
    public function __construct (
        private Node $node
    ) {}

    /**
     * ### Get encapsulated node
     * @since 1.0.0
     *
     * @return \FireHub\Core\Support\DataStructure\Storage\Node<TValue> Encapsulated node.
     */
    public function node ():Node {

        return $this->node;

    }

}