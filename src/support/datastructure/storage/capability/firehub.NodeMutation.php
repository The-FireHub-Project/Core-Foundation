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
 * ### Full Node Mutation Capability
 *
 * A composite capability that represents full structural mutation support for node-based storage systems. It
 * combines bidirectional insertion and node removal capabilities, enabling complete topological control over a linked
 * structure. Typically implemented by doubly linked or a circular linked storages.
 * @since 1.0.0
 *
 * @template TValue
 *
 * @extends \FireHub\Core\Support\DataStructure\Storage\Capability\NodeBidirectionalInsert<TValue>
 * @extends \FireHub\Core\Support\DataStructure\Storage\Capability\NodeRemoval<TValue>
 */
interface NodeMutation extends NodeBidirectionalInsert, NodeRemoval {}