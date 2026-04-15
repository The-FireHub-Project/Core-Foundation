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

/**
 * ### Collection Contract
 *
 * A Collection is a structured, stateful data container that stores and manages a finite set of elements. It
 * provides consistent, repeatable iteration and supports common data operations such as adding, removing,
 * and transforming items while preserving internal state and order guarantees depending on its specific type
 * (e.g., linear, associative, or set-based).
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @extends \FireHub\Core\Support\DataStructure\Abstraction\Enumerable<TKey, TValue>
 */
interface Collection extends Enumerable {

}