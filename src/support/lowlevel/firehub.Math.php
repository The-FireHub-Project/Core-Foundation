<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.4
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use function max;

/**
 * ### Math low-level proxy class
 *
 * Math utilities act as thin proxies over native PHP numeric and mathematical functions.
 * @since 1.0.0
 *
 * @internal
 */
final class Math {

    /**
     * ### Find the highest value
     * @since 1.0.0
     *
     * @template TValue
     *
     * @param TValue $value <p>
     * Any comparable value.
     * </p>
     * @param TValue ...$values <p>
     * Any comparable values.
     * </p>
     *
     * @return TValue Value considered "highest" according to standard comparisons.
     *
     * @caution Be careful when passing arguments of different types because the method can produce unpredictable
     * results.
     */
    public static function max (mixed $value, mixed ...$values):mixed {

        return max([$value, ...$values]);

    }

}