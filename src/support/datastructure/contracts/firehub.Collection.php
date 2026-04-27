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

namespace FireHub\Core\Support\DataStructure\Contracts;

use FireHub\Core\Support\DataStructure\Enumerable;

/**
 * ### Collection Contract
 *
 * Represents a finite, stateful data structure that holds a set of elements in memory.<br>
 * A collection provides consistent and repeatable iteration over its elements and serves as a base abstraction for
 * structured data types such as linear, associative, and set-based collections.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @extends \FireHub\Core\Support\DataStructure\Enumerable<TKey, TValue>
 */
interface Collection extends Enumerable {}