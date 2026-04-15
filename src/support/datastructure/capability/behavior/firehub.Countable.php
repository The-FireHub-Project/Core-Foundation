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

namespace FireHub\Core\Support\DataStructure\Capability\Behavior;

use FireHub\Core\Shared\Contracts\Countable as CountableContract;

/**
 * ### Countable Behavior Contract
 *
 * Defines the ability to determine the number of elements within a structure. Ensures that the structure can provide
 * a consistent and reliable size or element count at any given time.
 * @since 1.0.0
 */
interface Countable extends CountableContract {}