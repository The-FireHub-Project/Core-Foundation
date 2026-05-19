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
 * ### Bidirectional Node Insertion Capability
 *
 * A composite capability that combines both forward (after) and backward (before) node insertion operations. It
 * represents full positional insertion control within a node-based storage topology and is typically supported by
 * doubly linked structures.
 * @since 1.0.0
 *
 * @template TValue
 *
 * @extends \FireHub\Core\Support\DataStructure\Storage\Capability\NodeInsertBefore<TValue>
 * @extends \FireHub\Core\Support\DataStructure\Storage\Capability\NodeInsertAfter<TValue>
 */
interface NodeBidirectionalInsert extends NodeInsertBefore, NodeInsertAfter {}