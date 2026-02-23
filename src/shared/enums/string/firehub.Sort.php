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
 * ### Sorting types enum
 *
 * Defines the sorting behavior when ordering strings.
 * @since 1.0.0
 *
 * @api
 */
enum Sort:int {

    /**
     * ### Sort items normally
     * @since 1.0.0
     */
    case BY_REGULAR = 0;

    /**
     * ### Sort items numerically
     * @since 1.0.0
     */
    case BY_NUMERIC = 1;

    /**
     * ### Sort items as strings
     * @since 1.0.0
     */
    case BY_STRING = 2;

    /**
     * ### Sort items as strings, based on the current locale
     * @since 1.0.0
     */
    case BY_LOCALE_STRING = 5;

    /**
     * ### Sort items as strings using "natural ordering" like natsort()
     * @since 1.0.0
     */
    case BY_NATURAL = 6;

    /**
     * ### Sort strings case-insensitively
     * @since 1.0.0
     */
    case BY_STRING_FLAG_CASE = 10;

    /**
     * ### Sort natural case-insensitively
     * @since 1.0.0
     */
    case BY_NATURAL_FLAG_CASE = 14;

}