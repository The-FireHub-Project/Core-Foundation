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

namespace FireHub\Core\Support\DataStructure\Abstraction;

use FireHub\Core\Support\Contracts\DataStructure;
use FireHub\Core\Shared\Contracts\IteratorAggregate;

/**
 * ### Enumerable Contract
 *
 * Defines the ability to iterate over all elements in a structure. Provides higher-level traversal operations such
 * as mapping, filtering, and transformation, typically built on top of a traversal mechanism.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @extends \FireHub\Core\Support\Contracts\DataStructure<TKey, TValue>
 * @extends \FireHub\Core\Shared\Contracts\IteratorAggregate<TKey, TValue>
 */
interface Enumerable extends DataStructure, IteratorAggregate {

}