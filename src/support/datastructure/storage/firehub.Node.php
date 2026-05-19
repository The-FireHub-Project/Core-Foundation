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

namespace FireHub\Core\Support\DataStructure\Storage;

use FireHub\Core\Support\DataStructure\Storage;

/**
 * ### Base Storage Node Contract
 *
 * A minimal structural contract representing a node inside a storage implementation. It defines only value ownership
 * semantics without imposing any constraints on linkage, traversal, or topology.
 * @since 1.0.0
 *
 * @template TValue
 */
interface Node {

    /**
     * ### Retrieves the storage instance that owns this node
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage As return.
     *
     * @return \FireHub\Core\Support\DataStructure\Storage<mixed, mixed> Storage instance that owns this node.
     */
    public function owner ():Storage;

    /**
     * ### Get the value contained in this node
     * @since 1.0.0
     *
     * @return TValue The value contained in this node.
     */
    public function value ():mixed;

}