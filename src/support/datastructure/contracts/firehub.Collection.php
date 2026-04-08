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

use FireHub\Core\Support\Contracts\DataStructure;

/**
 * ### Collection Contract
 *
 * Represents the core contract for all linear, iterable data structures in FireHub.<br>
 * This interface defines the minimal operations that all Collections should implement, serving as the foundation for
 * feature-rich Professional and Enterprise collections.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @extends \FireHub\Core\Support\Contracts\DataStructure<TKey, TValue>
 */
interface Collection extends DataStructure {

}