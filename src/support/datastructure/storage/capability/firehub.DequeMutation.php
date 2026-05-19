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
 * ### Deque End Mutation Capability
 *
 * Defines the ability of a storage structure to perform double-ended mutations on a linear sequence. This includes
 * adding elements to both ends (append and prepend) as well as removing elements from both ends (pop and shift).
 * It is intended for data structures that maintain ordered elements with efficient front and back operations, such as
 * deque, linked lists, and sequence-based storages.
 * @since 1.0.0
 *
 * @template TValue
 *
 * @extends \FireHub\Core\Support\DataStructure\Storage\Capability\FrontMutation<TValue>
 * @extends \FireHub\Core\Support\DataStructure\Storage\Capability\BackMutation<TValue>
 */
interface DequeMutation extends FrontMutation, BackMutation {}