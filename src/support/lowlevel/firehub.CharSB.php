<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.4
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use function chr;
use function ord;

/**
 * ### Single-byte character low-level proxy class
 *
 * Class provides lightweight, low-level utility methods for handling single-byte character operations.
 * @since 1.0.0
 */
final class CharSB {

    /**
     * ### Generate a single-byte string from a number
     *
     * Returns a one-character string containing the character specified by interpreting $codepoint as an unsigned
     * integer.<br>
     * This can be used to create a one-character string in a single-byte encoding such as ASCII, ISO-8859, or
     * Windows 1252, by passing the position of a desired character in the encoding's mapping table.
     * However, note that this function is not aware of any string encoding, and in particular can't be passed a
     * Unicode code point value to generate a string in a multibyte encoding like UTF-8 or UTF-16.<br>
     * This function complements {@see CharSB::ord() ord}.
     * @since 1.0.0
     *
     * @param int $codepoint <p>
     * An integer between 0 and 255.<br>
     * Values outside the range 0–255 are clamped to the nearest boundary.
     * </p>
     *
     * @link https://www.man7.org/linux/man-pages/man7/ascii.7.html List of codepoint values
     *
     * @return string A single-character string containing the specified byte.
     *
     * @todo Replace max and min with low-level equivalents when available.
     */
    public static function chr (int $codepoint):string {

        return chr(max(0, min(255, $codepoint)));

    }

    /**
     * ### Convert the first byte of a string to a value between 0 and 255
     *
     * Interprets the binary value of the first byte from $character as an unsigned integer between 0 and 255.
     * If the string is in a single-byte encoding, such as ASCII, ISO-8859, or Windows 1252, this is equivalent to
     * returning the position of a character in the character set's mapping table.<br>
     * However, note that this function is not aware of any string encoding, and in particular will never identify a
     * Unicode code point in a multibyte encoding such as UTF-8 or UTF-16.<br>
     * This function complements {@see CharSB::chr() chr}.
     * @since 1.0.0
     *
     * @param string $character <p>
     * A character.
     * - Empty string is treated as NUL ("\0")
     * - Strings longer than one byte are truncated to the first byte
     * </p>
     *
     * @return int<0, 255> An integer between 0 and 255.
     */
    public static function ord (string $character):int {

        return ord($character[0] ?? "\0");

    }

}