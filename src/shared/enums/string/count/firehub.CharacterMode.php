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

namespace FireHub\Core\Shared\Enums\String\Count;

/**
 * ### Character count mode for strings
 * @since 1.0.0
 */
enum CharacterMode:int {

    /**
     * ### Array with the byte-value as a key and the frequency of every byte as value
     * @since 1.0.0
     */
    case ARR_ALL = 0;

    /**
     * ### Array with the byte-value as a key and the frequency of every byte as value where frequency greater than zero
     * @since 1.0.0
     */
    case ARR_POSITIVE = 1;

    /**
     * ### Array with the byte-value as key and the frequency of every byte as a value where frequency equal to zero
     * @since 1.0.0
     */
    case ARR_ZERO = 2;

    /**
     * ### String containing all unique characters is returned
     * @since 1.0.0
     */
    case STR_UNIQUE = 3;

    /**
     * ### String containing all unused characters is returned
     * @since 1.0.0
     */
    case STR_UNUSED = 4;

}