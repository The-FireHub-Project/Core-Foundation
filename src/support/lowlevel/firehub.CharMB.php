<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.0
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Shared\Enums\String\Encoding;
use FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError;

use function mb_chr;
use function mb_ord;

/**
 * ### Multibyte character low-level proxy class
 *
 * Class provides lightweight, low-level utility methods for handling multibyte character operations.
 * @since 1.0.0
 */
final class CharMB {

    /**
     * ### Return character by Unicode code point value
     *
     * Returns a string containing the character specified by the Unicode code point value, encoded in the specified
     * encoding.<br>
     * This function complements {@see CharMB::ord() ord}.
     * @since 1.0.0
     *
     * @link https://en.wikipedia.org/wiki/List_of_Unicode_characters List of codepoint values
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding::isValid() To check if the provided encoding is valid.
     *
     * @param int $codepoint <p>
     * The codepoint value.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding.<br>
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError If the encoding is not valid.
     *
     * @return string|false A string containing the requested character if it can be represented in the specified
     * encoding or false on failure.
     */
    public static function chr (int $codepoint, ?Encoding $encoding = null):string|false {

        if ($encoding !== null) self::validateEncoding($encoding);

        return mb_chr($codepoint, $encoding?->value);

    }

    /**
     * ### Get Unicode code point of character
     *
     * Returns the Unicode code point value of the given character.<br>
     * This function complements {@see CharMB::chr() chr}.
     * @since 1.0.0
     *
     * @link https://en.wikipedia.org/wiki/List_of_Unicode_characters List of codepoint values
     *
     * @uses \FireHub\Core\Support\LowLevel\CharMB::validateEncoding() To check if the provided encoding is valid.
     *
     * @param string $character <p>
     * A character.
     * - Empty string is treated as NUL ("\0")
     * - Strings longer than one character are truncated to the first character
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding.<br>
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError If the encoding is not valid.
     *
     * @return non-negative-int|false The Unicode code point for the first character of string.
     */
    public static function ord (string $character, ?Encoding $encoding = null):int|false {

        if ($encoding !== null) self::validateEncoding($encoding);

        /** @var non-negative-int|false */
        return mb_ord($character ?: "\0", $encoding?->value);

    }

    /**
     * ### Validate character encoding
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding As parameter.
     * @uses \FireHub\Core\Support\LowLevel\Arr::inArray() To check if the encoding exists in the list of supported
     * encodings.
     * @uses \FireHub\Core\Support\LowLevel\StrMB::listEncodings() To retrieve the list of supported encodings.
     *
     * @param \FireHub\Core\Shared\Enums\String\Encoding $encoding <p>
     * Character encoding.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError If the encoding is not valid.
     *
     * @return void
     */
    private static function validateEncoding (Encoding $encoding):void {

        Arr::inArray(StrMB::listEncodings(), $encoding->value)
            ?: throw new InvalidEncodingError;

    }

}