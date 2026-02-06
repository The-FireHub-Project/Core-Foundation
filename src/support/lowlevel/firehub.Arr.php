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

use function in_array;

/**
 * ### Array low-level proxy class
 *
 * Low-level proxy for PHP array functions; defensive, JIT-friendly, and deterministic. Replicates native behavior
 * without throwing exceptions, serving as a foundation for high-level array/collection operations.
 * @since 1.0.0
 */
final class Arr {

    /**
     * ### Checks if a value exists in an array
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array <p>
     * The array.
     * </p>
     * @param mixed $value <p>
     * The searched value.
     * If the value is a string, the comparison is done in a case-sensitive manner.
     * </p>
     *
     * @return bool True if a value is found in the array, false otherwise.
     */
    public static function inArray (array $array, mixed $value):bool {

        return in_array($value, $array, true);

    }

}