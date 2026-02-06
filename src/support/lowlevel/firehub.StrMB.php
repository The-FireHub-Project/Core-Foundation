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

use function mb_list_encodings;

/**
 * ### Multibyte string low-level proxy class
 *
 * Low-level multibyte string proxy; provides defensive, deterministic, JIT-friendly access to PHP mbstring functions
 * without throwing exceptions.
 * @since 1.0.0
 */
final class StrMB {

    /**
     * ### List of all supported encodings
     * @since 1.0.0
     *
     * @return non-empty-list<string> Returns a numerically indexed array of all available encodings.
     */
    public static function listEncodings ():array {

        return mb_list_encodings();

    }

}