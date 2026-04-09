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

namespace FireHub\Core\Support\DataStructure;

use FireHub\Core\Support\Contracts\DataStructure;

/**
 * ### Linear Data Structure
 *
 * Defines data structures where elements are arranged in a strict linear sequence. Each element has a clear
 * predecessor and successor (except boundaries), enabling predictable traversal, ordered processing, and sequential
 * access patterns.
 * @since 1.0.0
 *
 * @template TValue
 *
 * @extends \FireHub\Core\Support\Contracts\DataStructure<mixed, TValue>
 */
interface Linear extends DataStructure {}