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
use FireHub\Core\Shared\Enums\ {
    Side, String\CaseFolding, String\Encoding
};
use FireHub\Core\Throwable\Error\LowLevel\String\ {
    ChunkLengthLessThanOneError, InvalidEncodingError
};
use ValueError;

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
     * ### Strip whitespace (or other characters) from the beginning and end of a string
     *
     * Performs a multibyte safe StrSB#trim() operation and returns a string with whitespace stripped from
     * the beginning and end of the string.<br>
     * Without the second parameter, StrMB#trim() will strip these characters:
     *
     * - " " (Unicode U+0020), an ordinary space.
     * - "\t" (Unicode U+0009), a tab.
     * - "\n" (Unicode U+000A), a new line (line feed).
     * - "\r" (Unicode U+000D), a carriage return.
     * - "\0" (Unicode U+0000), the NUL-byte.
     * - "\v" (Unicode U+000B), a vertical tab.
     * - "\f" (Unicode U+000C), a form feed.
     * - "\u00A0" (Unicode U+00A0), a NO-BREAK SPACE.
     * - "\u1680" (Unicode U+1680), a OGHAM SPACE MARK.
     * - "\u2000" (Unicode U+2000), an EN QUAD.
     * - "\u2001" (Unicode U+2001), an EM QUAD.
     * - "\u2002" (Unicode U+2002), an EN SPACE.
     * - "\u2003" (Unicode U+2003), an EM SPACE.
     * - "\u2004" (Unicode U+2004), a THREE-PER-EM SPACE.
     * - "\u2005" (Unicode U+2005), a FOUR-PER-EM SPACE.
     * - "\u2006" (Unicode U+2006), a SIX-PER-EM SPACE.
     * - "\u2007" (Unicode U+2007), a FIGURE SPACE.
     * - "\u2008" (Unicode U+2008), a PUNCTUATION SPACE.
     * - "\u2009" (Unicode U+2009), a THIN SPACE.
     * - "\u200A" (Unicode U+200A), a HAIR SPACE.
     * - "\u2028" (Unicode U+2028), a LINE SEPARATOR.
     * - "\u2029" (Unicode U+2029), a PARAGRAPH SEPARATOR.
     * - "\u202F" (Unicode U+202F), a NARROW NO-BREAK SPACE.
     * - "\u205F" (Unicode U+205F), a MEDIUM MATHEMATICAL SPACE.
     * - "\u3000" (Unicode U+3000), a IDEOGRAPHIC SPACE.
     * - "\u0085" (Unicode U+0085), a NEXT LINE (NEL).
     * - "\u180E" (Unicode U+180E), a MONGOLIAN VOWEL SEPARATOR.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\Side::BOTH If trimming string on the both sides.
     * @uses \FireHub\Core\Shared\Enums\Side::LEFT If trimming string on the left side.
     * @uses \FireHub\Core\Shared\Enums\Side::RIGHT If trimming string on the right side.
     *
     * @param string $string <p>
     * The string that will be trimmed.
     * </p>
     * @param \FireHub\Core\Shared\Enums\Side $side [optional] <p>
     * Side to trim string.
     * </p>
     * @param null|string $characters [optional] <p>
     * Optionally, the stripped characters can also be specified using the character parameter.<br>
     * List all characters that need to be stripped.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding. If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return string The trimmed string.
     */
    public static function trim (string $string, Side $side = Side::BOTH, ?string $characters = null, ?Encoding $encoding = null):string {

        return match($side) {
            Side::LEFT => mb_ltrim($string, $characters, $encoding?->value),
            Side::RIGHT => mb_rtrim($string, $characters, $encoding?->value),
            SIDE::BOTH => mb_trim($string, $characters, $encoding?->value)
        };

    }

    /**
     * ### Given a multibyte string, return an array of its characters
     *
     * This function will return an array of strings, it is a version of StrSB#split() with support for encodings of
     * variable character size as well as fixed-size encodings of 1,2 or 4 byte characters.<br>
     * If the $length parameter is specified, the string is broken down into chunks of the specified length in
     * characters (not bytes).<br>
     * The $encoding parameter can be optionally specified, and it is good practice to do so.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding The encoding parameter for character encoding.
     *
     * @param string $string <p>
     * The input string.
     * </p>
     * @param positive-int $length [optional] <p>
     * Maximum length of the chunk.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding.<br>
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\ChunkLengthLessThanOneError If the length is less than 1.
     *
     * @return list<non-empty-string> If the optional $length parameter is specified, the returned array will be broken
     * down into chunks with each being $length in length, except the final chunk, which may be shorter if the string
     * doesn't divide evenly.<br>
     * The default $length is 1, meaning every chunk will be one character in size.
     */
    public static function split (string $string, int $length = 1, ?Encoding $encoding = null):array {

        return $length >= 1
            ? mb_str_split($string, $length, $encoding?->value)
            : throw new ChunkLengthLessThanOneError;

    }

    /**
     * ### Get the number of times the searched substring occurs in the string
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding The encoding parameter for character encoding.
     *
     * @param string $string <p>
     * The string being checked.
     * </p>
     * @param string $search <p>
     * The string being found.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding.<br>
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return non-negative-int The number of times the searched substring occurs in the string.
     */
    public static function partCount (string $string, string $search, ?Encoding $encoding = null):int {

        return mb_substr_count($string, $search, $encoding?->value);

    }

    /**
     * ### Get string length
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding The encoding parameter for character encoding.
     *
     * @param string $string <p>
     * The string being measured for length.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding.<br>
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return non-negative-int String length.
     */
    public static function length (string $string, ?Encoding $encoding = null):int {

        return mb_strlen($string, $encoding?->value);

    }

    /**
     * ### Find the position of the first occurrence for a substring in a string
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding The encoding parameter for character encoding.
     *
     * @param string $search <p>
     * A string to find position.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Search case-sensitive position.
     * </p>
     * @param int $offset [optional] <p>
     * If specified, search will start this number of characters counted from the beginning of the string.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding.<br>
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return false|non-negative-int Numeric position of the first occurrence or false if none exist.
     */
    public static function firstPosition (string $search, string $string, bool $case_sensitive = true, int $offset = 0, ?Encoding $encoding = null):false|int {

        if ($case_sensitive) return mb_strpos($string, $search, $offset, $encoding?->value);

        return mb_stripos($string, $search, $offset, $encoding?->value);

    }

    /**
     * ### Find the position of the last occurrence for a substring in a string
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding The encoding parameter for character encoding.
     *
     * @param string $search <p>
     * A string to find position.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Search case-sensitive position.
     * </p>
     * @param int $offset [optional] <p>
     * If specified, search will start this number of characters counted from the beginning of the string.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Character encoding.<br>
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @return false|non-negative-int Numeric position of the last occurrence or false if none exist.
     */
    public static function lastPosition (string $search, string $string, bool $case_sensitive = true, int $offset = 0, ?Encoding $encoding = null):false|int {

        if ($case_sensitive) return mb_strrpos($string, $search, $offset, $encoding?->value);

        return mb_strripos($string, $search, $offset, $encoding?->value);

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

    /**
     * ### Set/Get internal character encoding
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding The encoding parameter for character encoding.
     *
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding [optional] <p>
     * Encoding is the character encoding name used for the HTTP input character encoding conversion, HTTP output
     * character encoding conversion, and the default character encoding for string functions defined by the mbstring
     * module.<br>
     * You should notice that the internal encoding is totally different from the one for multibyte regex.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError If we couldn't get current encoding.
     *
     * @return ($encoding is null ? \FireHub\Core\Shared\Enums\String\Encoding : true) If encoding is set, then
     * returns true.<br>
     * In this case, the character encoding for multibyte regex is NOT changed.<br>
     * If encoding is omitted, then the current character encoding name is returned.
     */
    public static function encoding (?Encoding $encoding = null):true|Encoding {

        return $encoding
            ? mb_internal_encoding($encoding->value)
            : (($new_encoding = Encoding::tryFrom(mb_internal_encoding()))
                ? $new_encoding : throw new InvalidEncodingError);

    }

    /**
     * ### Detect character encoding
     *
     * Detects the most likely character encoding for string from an ordered list of candidates.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding As detected encoding.
     *
     * @param string $string <p>
     * The string to detect encoding.
     * </p>
     *
     * @return null|\FireHub\Core\Shared\Enums\String\Encoding The detected character encoding, or null if the string
     * is not valid in any of the listed encodings.
     */
    public static function detectEncoding (string $string):?Encoding {

        $cases = [];
        foreach (Encoding::cases() as $case) $cases[] = $case->value;

        return Encoding::tryFrom(
            mb_detect_encoding($string, $cases, true) ?: ''
        );

    }

    /**
     * ### Convert a string from one character encoding to another
     *
     * Converts string from $from, or the current internal encoding, to $to.<br>
     * If a string is an array, all its $string values will be converted recursively.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding As converted encoding.
     *
     * @param string $string <p>
     * The string to be converted.
     * </p>
     * @param \FireHub\Core\Shared\Enums\String\Encoding $to <p>
     * The desired encoding of the result.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $from [optional] <p>
     * Character encoding.
     * If it is null, the internal character encoding value will be used.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError If the value of $to or $from is
     * an invalid encoding, or couldn't convert encoding.
     *
     * @return string Encoded string.
     */
    public static function convertEncoding (string $string, Encoding $to, ?Encoding $from = null):string {

        try {

            return mb_convert_encoding($string, $to->value, $from?->value)
                ?: throw new InvalidEncodingError;

        } catch (ValueError $error) {

            throw new InvalidEncodingError($error->getMessage());

        }

    }

    /**
     * ### Check if strings are valid for the specified encoding
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Encoding As checked encoding.
     *
     * @param string $string <p>
     * The string to check encoding on.
     * </p>
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding <p>
     * The expected encoding.
     * </p>
     *
     * @return bool True on success or false on failure.
     */
    public static function checkEncoding (string $string, ?Encoding $encoding = null):bool {

        return mb_check_encoding($string, $encoding?->value);

    }

}