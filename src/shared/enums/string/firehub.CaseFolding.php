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
 * ### Case folding modes for string transformations
 *
 * Enum defining the available strategies for converting string cases.
 * Useful for normalizing text before comparison or display.
 * @since 1.0.0
 *
 * @api
 */
enum CaseFolding:int {

    /**
     * ### Lower-case folding
     *
     * Converts all characters in a string to lower case.
     * <code>
     *   "Hello World" → "hello world"
     * </code>
     * @since 1.0.0
     */
    case LOWER = 0;

    /**
     * ### Upper-case folding
     *
     * Converts all characters in a string to the upper case.
     * <code>
     *   "Hello World" → "HELLO WORLD"
     * </code>
     * @since 1.0.0
     */
    case UPPER = 1;

    /**
     * ### Title-case folding
     *
     * Converts the first character of each word to the upper case and the rest to the lower case.
     * <code>
     *   "hello world" → "Hello World"
     * </code>
     * @since 1.0.0
     */
    case TITLE = 2;

}