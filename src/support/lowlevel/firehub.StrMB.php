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
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;

use function mb_check_encoding;
use function mb_convert_case;
use function mb_convert_encoding;
use function mb_detect_encoding;
use function mb_internal_encoding;
use function mb_lcfirst;
use function mb_list_encodings;
use function mb_ltrim;
use function mb_rtrim;
use function mb_str_split;
use function mb_stripos;
use function mb_stristr;
use function mb_strlen;
use function mb_strpos;
use function mb_strrchr;
use function mb_strrichr;
use function mb_strripos;
use function mb_strrpos;
use function mb_strstr;
use function mb_substr;
use function mb_substr_count;
use function mb_trim;
use function mb_ucfirst;

/**
 * ### Multibyte string low-level proxy class
 *
 * Low-level multibyte string proxy; provides defensive, deterministic, JIT-friendly access to PHP mbstring functions
 * without throwing exceptions.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class StrMB extends LowLevel {

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