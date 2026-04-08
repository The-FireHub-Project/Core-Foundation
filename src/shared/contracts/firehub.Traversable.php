<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core\Shared
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Shared\Contracts;

use Traversable as InternalTraversable;

/**
 * ### Base traversable contract
 *
 * Interface to detect if a class is traversable using foreach.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @extends InternalTraversable<TKey, TValue>
 */
interface Traversable extends InternalTraversable {}