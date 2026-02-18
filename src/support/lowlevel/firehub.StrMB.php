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

use FireHub\Core\Support\LowLevel;
use FireHub\Core\Shared\Enums\String\ {
    CaseFolding, Encoding
};

use const MB_CASE_LOWER;
use const MB_CASE_TITLE;
use const MB_CASE_UPPER;

use function mb_check_encoding;
use function mb_convert_case;
use function mb_convert_encoding;
use function mb_detect_encoding;
use function mb_internal_encoding;
use function mb_lcfirst;
use function mb_list_encodings;
use function mb_ltrim;
use function mb_rtrim;
use function mb_str_split;
use function mb_stripos;
use function mb_stristr;
use function mb_strlen;
use function mb_strpos;
use function mb_strrchr;
use function mb_strrichr;
use function mb_strripos;
use function mb_strrpos;
use function mb_strstr;
use function mb_substr;
use function mb_substr_count;
use function mb_trim;
use function mb_ucfirst;

/**
 * ### Multibyte string low-level proxy class
 *
 * Low-level multibyte string proxy; provides defensive, deterministic, JIT-friendly access to PHP mbstring functions
 * without throwing exceptions.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class StrMB extends LowLevel {

    /**
     * ### Perform case folding on a string
     *
     * Performs case folding on a string, converted in the way specified by $caseFolding.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding The encoding parameter for character encoding.
     * @uses \FireHub\Core\Shared\Enums\String\CaseFolding::UPPER To convert to uppercase.
     * @uses \FireHub\Core\Shared\Enums\String\CaseFolding::LOWER To convert to lowercase.
     * @uses \FireHub\Core\Shared\Enums\String\CaseFolding::TITLE To convert to a title-case.
     *
     * @param string $string <p>
     * The string being converted.
     * </p>
     * @param \FireHub\Core\Shared\Enums\String\CaseFolding $case_folding <p>
     * The case folding type.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return (
     *  $case_folding is CaseFolding::UPPER
     *  ? uppercase-string
     *  : ($case_folding is CaseFolding::LOWER
     *    ? lowercase-string
     *    : string)
     * ) Converted string.
     */
    public static function convert (string $string, CaseFolding $case_folding, ?Encoding $encoding = null):string {

        return mb_convert_case($string, match ($case_folding) {
            CaseFolding::UPPER => MB_CASE_UPPER,
            CaseFolding::LOWER => MB_CASE_LOWER,
            CaseFolding::TITLE => MB_CASE_TITLE
        }, $encoding?->value);

    }

    /**
     * ### Make the first character of a string uppercased
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being converted.
     * </p>
     *
     * @return ($string is empty ? '' : non-empty-string) String with the first character uppercased.
     */
    public static function capitalize (string $string):string {

        return mb_ucfirst($string);

    }

    /**
     * ### Make the first character of string lowercased
     *
     * Returns a string with the first character of $string lowercased if that character is an ASCII character in the
     * range "A" (0x41) to "Z" (0x5a).
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being converted.
     * </p>
     *
     * @return ($string is empty ? '' : non-empty-string) String with the first character lowercased.
     */
    public static function deCapitalize (string $string):string {

        return mb_lcfirst($string);

    }

    /**
     * ### Get part of string
     *
     * Performs a multibyte safe StrSB#part() operation based on the number of characters.<br>
     * Position is counted from the beginning of $string.<br>
     * The first character's position is 0.<br>
     * The second character's position is 1, and so on.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding The encoding parameter for character encoding.
     *
     * @param string $string <p>
     * The string to extract the substring from.
     * </p>
     * @param int $start <p>
     * If start is non-negative, the returned string will start at the start position in string, counting from zero.<br>
     * For instance, in the string 'abcdef', the character at position 0 is 'a', the character at position 2 is 'c',
     * and so forth.<br>
     * If the start is negative, the returned string will start at the start character from the end of the string.
     * </p>
     * @param null|int $length [optional] <p>
     * Maximum number of characters to use from string.<br>
     * If omitted or NULL is passed, extract all characters to the end of the string.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding.<br>
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return string The portion of string specified by the start and length parameters.
     */
    public static function part (string $string, int $start, ?int $length = null, ?Encoding $encoding = null):string {

        return mb_substr($string, $start, $length, $encoding?->value);

    }

    /**
     * ### Find the first occurrence of a string
     *
     * Returns part of $string starting from and including the first occurrence of $find to the end of $string.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding The encoding parameter for character encoding.
     *
     * @param string $find <p>
     * String to find.
     * </p>
     * @param string $string <p>
     * The string being searched.
     * </p>
     * @param bool $before_needle [optional] <p>
     * If true, return the part of the string before the first occurrence (excluding the find string).
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Is string to find case-sensitive or not.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding.<br>
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return string|false The portion of string or false if the $find is not found.
     */
    public static function firstOccurrence (string $find, string $string, bool $before_needle = false, bool $case_sensitive = true, ?Encoding $encoding = null):string|false {

        if ($case_sensitive) return mb_strstr($string, $find, $before_needle, $encoding?->value);

        return mb_stristr($string, $find, $before_needle, $encoding?->value);

    }

    /**
     * ### Finds the last occurrence of any character from $find within $string
     *
     * This function finds the last occurrence of a $find in the $string and returns the portion of $string.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding The encoding parameter for character encoding.
     *
     * @param string $find <p>
     * String to find.
     * </p>
     * @param string $string <p>
     * The string being searched.
     * </p>
     * @param bool $before_needle [optional] <p>
     * If true, return the part of the string before the last occurrence (excluding the find string).
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Is string to find case-sensitive or not.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding.<br>
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return string|false The portion of string, or false if the $find is not found.
     */
    public static function lastCharacterFrom (string $find, string $string, bool $before_needle = false, bool $case_sensitive = true, ?Encoding $encoding = null):string|false {

        if ($case_sensitive) return mb_strrchr($string, $find, $before_needle, $encoding?->value);

        return mb_strrichr($string, $find, $before_needle, $encoding?->value);

    }

    /**
     * ### List of all supported encodings
     * @since 1.0.0
     *
     * @return non-empty-list<string> Returns a numerically indexed array of all available encodings.
     */
    public static function listEncodings ():array {

        return mb_list_encodings();

    }

}