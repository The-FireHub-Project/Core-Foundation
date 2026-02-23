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
 * ### Enums flags for encode functions
 * @since 1.0.0
 *
 * @api
 */
enum Encode:int {

    /**
     * ### All < and > are converted to \u003C and \u003E
     * @since 1.0.0
     */
    case HEX_TAG = 1;

    /**
     * ### All & are converted to \u0026
     * @since 1.0.0
     */
    case HEX_AMP = 2;

    /**
     * ### All ' are converted to \u0027
     * @since 1.0.0
     */
    case HEX_APOS = 3;

    /**
     * ### All " are converted to \u0022
     * @since 1.0.0
     */
    case HEX_QUOT = 8;

    /**
     * ### Outputs an object rather than an array when a non-associative array is used
     * @since 1.0.0
     */
    case FORCE_OBJECT = 16;

    /**
     * ### Encodes numeric strings as numbers
     * @since 1.0.0
     */
    case NUMERIC_CHECK = 32;

    /**
     * ### Don't escape /
     * @since 1.0.0
     */
    case UNESCAPED_SLASHES = 64;

    /**
     * ### Use whitespace in returned data to format it
     * @since 1.0.0
     */
    case PRETTY_PRINT = 128;

    /**
     * ### Encode multibyte Unicode characters literally (default is to escape as \uXXXX)
     * @since 1.0.0
     */
    case UNESCAPED_UNICODE = 256;

    /**
     * ### Substitute some un-encodable values instead of failing
     * @since 1.0.0
     */
    case PARTIAL_OUTPUT_ON_ERROR = 512;

    /**
     * ### Ensures that float values are always encoded as a float value
     * @since 1.0.0
     */
    case PRESERVE_ZERO_FRACTION = 1024;

    /**
     * ### The line terminators are kept unescaped when UNESCAPED_UNICODE is supplied
     * @since 1.0.0
     */
    case UNESCAPED_LINE_TERMINATORS = 2048;

}