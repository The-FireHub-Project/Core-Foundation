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
 * ### Stream Contract
 *
 * A Stream is a lazy, single-pass data structure that produces elements on demand during iteration. It does not
 * store data in memory as a collection but instead computes or retrieves each element as it is traversed.
 * Streams are ideal for processing large or infinite datasets, enabling transformations and operations like mapping
 * and filtering without materializing the entire dataset.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @extends \FireHub\Core\Support\DataStructure\Abstraction\Enumerable<TKey, TValue>
 */
interface Stream extends Enumerable {}