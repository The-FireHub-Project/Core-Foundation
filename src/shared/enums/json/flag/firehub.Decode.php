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

namespace FireHub\Core\Shared\Enums\Json\Flag;

/**
 * ### Enums flags for decode functions
 * @since 1.0.0
 *
 * @api
 */
enum Decode:int {

    /**
     * ### Decodes JSON objects as a PHP array
     * @since 1.0.0
     */
    case OBJECT_AS_ARRAY = 1;

    /**
     * ### Decodes large integers as their original string value
     * @since 1.0.0
     */
    case BIGINT_AS_STRING = 2;

}