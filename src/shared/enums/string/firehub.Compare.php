<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.1
 * @package Core\Shared
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Shared\Enums\String;

/**
 * ### Comparison type enum
 *
 * Defines how string values are compared.
 * @since 1.0.0
 *
 * @api
 */
enum Compare:int {

    /**
     * ### Compare items normally
     * @since 1.0.0
     */
    case AS_REGULAR = 0;

    /**
     * ### Compare items numerically
     * @since 1.0.0
     */
    case AS_NUMERIC = 1;

    /**
     * ### Compare items as strings
     * @since 1.0.0
     */
    case AS_STRING = 2;

    /**
     * ### Compare items as strings, based on the current locale
     * @since 1.0.0
     */
    case AS_LOCALE_STRING = 5;

}