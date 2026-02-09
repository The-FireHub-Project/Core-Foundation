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

namespace FireHub\Core\Shared\Enums\Data;

/**
 * ### Data category enum
 *
 * Defines the low-level category of a data type in PHP. Categories classify types into scalar (single-value),
 * compound (multi-value), and special (system-specific) types, helping standardize type handling across
 * the FireHub ecosystem.
 * @since 1.0.0
 */
enum Category {

    /**
     * ### Scalar (predefined) category can hold only a single value
     * @since 1.0.0
     */
    case SCALAR;

    /**
     * ### Compound (user-defined) category can hold only multiple values
     * @since 1.0.0
     */
    case COMPOUND;

    /**
     * ### Special type
     * @since 1.0.0
     */
    case SPECIAL;

}