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

namespace FireHub\Core\Shared\Enums\Json;

/**
 * ### Enums are for both encode and decode functions
 * @since 1.0.0
 *
 * @api
 */
enum Flag:int {

    /**
     * ### The value passed to json_encode() includes a non-backed enum which can't be serialized
     * @since 1.0.0
     */
    case ERROR_NON_BACKED_ENUM = 11;

    /**
     * ### Ignore invalid UTF-8 characters
     * @since 1.0.0
     */
    case INVALID_UTF8_IGNORE = 1048576;

    /**
     * ### Convert invalid UTF-8 characters to \0xfffd (Unicode Character 'REPLACEMENT CHARACTER')
     * @since 1.0.0
     */
    case INVALID_UTF8_SUBSTITUTE = 2097152;

    /**
     * ### Throws JsonException if an error occurs instead of setting the global error state
     * @since 1.0.0
     */
    case THROW_ON_ERROR = 4194304;

}