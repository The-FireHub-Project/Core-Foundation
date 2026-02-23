<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.1
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;
use FireHub\Core\Shared\Enums\Side;
use FireHub\Core\Shared\Enums\String\Count\ {
    CharacterMode, WordFormat
};
use FireHub\Core\Throwable\Error\LowLevel\String\ {
    ChunkLengthLessThanOneError, ComparePartError, EmptyPadError, EmptySeparatorError
};
use Stringable, ValueError;

use const FireHub\Core\Shared\Constants\Number\MAX;

use function addslashes;
use function addcslashes;
use function chunk_split;
use function count_chars;
use function explode;
use function implode;
use function lcfirst;
use function ltrim;
use function quotemeta;
use function rtrim;
use function str_contains;
use function str_ends_with;
use function str_ireplace;
use function str_pad;
use function str_replace;
use function str_repeat;
use function str_shuffle;
use function str_split;
use function str_starts_with;
use function str_word_count;
use function strcasecmp;
use function strcmp;
use function strcspn;
use function stripcslashes;
use function stristr;
use function strip_tags;
use function stripos;
use function stripslashes;
use function strlen;
use function strncmp;
use function strpbrk;
use function strpos;
use function strrchr;
use function strstr;
use function strrev;
use function strripos;
use function strrpos;
use function strspn;
use function strtolower;
use function strtoupper;
use function strtr;
use function substr;
use function substr_compare;
use function substr_count;
use function substr_replace;
use function trim;
use function ucfirst;
use function ucwords;
use function wordwrap;

/**
 * ### Single-byte string low-level proxy class
 *
 * Single-byte multibyte string proxy; provides defensive, deterministic, JIT-friendly access to PHP string functions
 * without throwing exceptions.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class StrSB extends LowLevel {

    /**
     * ### Checks if a string contains a value
     *
     * Performs a case-sensitive check indicating if $string is contained in $string.
     * @since 1.0.0
     *
     * @param string $value <p>
     * The value to search for.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     *
     * @return bool True if a string contains a value, false otherwise.
     */
    public static function contains (string $value, string $string):bool {

        return str_contains($string, $value);

    }

    /**
     * ### Checks if a string starts with a given value
     *
     * Performs a case-sensitive check indicating if $string begins with $value.
     * @since 1.0.0
     *
     * @param string $value <p>
     * The value to search for.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     *
     * @return bool True if the string starts with value, false otherwise.
     */
    public static function startsWith (string $value, string $string):bool {

        return str_starts_with($string, $value);

    }

    /**
     * ### Checks if a string ends with a given value
     *
     * Performs a case-sensitive check indicating if $string ends with $value.
     * @since 1.0.0
     *
     * @param string $value <p>
     * The value to search for.
     * </p>
     * @param string $string <p>
     * The string to search in.
     * </p>
     *
     * @return bool True if the string ends with value, false otherwise.
     */
    public static function endsWith (string $value, string $string):bool {

        return str_ends_with($string, $value);

    }

    /**
     * ### Quote string with slashes
     *
     * Backslashes are added before characters that need to be escaped: (single quote, double quote, backslash, NUL).
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be escaped.
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string) The escaped string.
     *
     * @caution The StrSB#addSlashes() is sometimes incorrectly used to try to prevent SQL Injection.<br>
     * Instead, database-specific escaping functions and/or prepared statements should be used.
     */
    public static function addSlashes (string $string):string {

        return addslashes($string);

    }

    /**
     * ### Quote string with slashes in a C style
     *
     * Returns a string with backslashes before characters that are listed in characters parameter.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be escaped.
     * </p>
     * @param string $characters <p>
     * The list of characters to be escaped.<br>
     * Non-alphanumeric characters with ASCII codes lower than 32 and higher than 126 converted to octal representation.
     * </p>
     *
     * @return string The escaped string.
     */
    public static function addCSlashes (string $string, string $characters):string {

        return addcslashes($string, $characters);

    }

    /**
     * ### Join array elements with a string
     *
     * Join array elements with a $separator string.
     * @since 1.0.0
     *
     * @param array<array-key, null|scalar|Stringable> $array <p>
     * The array of strings to implode.
     * </p>
     * @param string $separator [optional] <p>
     * The boundary string.
     * </p>
     *
     * @return string Returns a string containing a string representation of all the array elements in the same order,
     * with the separator string between each element.
     */
    public static function implode (array $array, string $separator = ''):string {

        return implode($separator, $array);

    }

    /**
     * ### Quote meta-characters
     *
     * Returns a version of str with a backslash character (\) before every character that is among these: .\+*?[^]($).
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     *
     * @return ($string is empty ? '' : non-empty-string) The string with meta-characters quoted.
     */
    public static function quoteMeta (string $string):string {

        return quotemeta($string);

    }

    /**
     * ### Repeat a string
     *
     * Returns string repeated $times times.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string is to be repeated.
     * </p>
     * @param int $times <p>
     * Number of times the input string should be repeated.<br>
     * Multiplier has to be greater than or equal to 0.<br>
     * If the $times are set to 0 or less, the function will return an empty string.
     * </p>
     * @param string $separator [optional] <p>
     * Separator in between any repeated string.
     * </p>
     *
     * @return string Repeated string.
     *
     * @note If $times is less than 1, an empty string will be returned.
     */
    public static function repeat (string $string, int $times, string $separator = ''):string {

        return $times < 1 ? '' : str_repeat($string.$separator, $times - 1).$string;

    }

    /**
     * ### Strip HTML and PHP tags from a string
     *
     * This function tries to return a string with all NULL bytes, HTML and PHP tags stripped from a given string.<br>
     * It uses the same tag stripping state machine as the fgetss() function.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     * @param null|string|array<int, string> $allowed_tags <p>
     * You can use the optional second parameter to specify tags which shouldn't be stripped.
     *
     * @return string the Stripped string.
     *
     * @note Self-closing XHTML tags are ignored, and only non-self-closing tags should be used in allowed_tags.<br>
     * For example, to allow both ```<br>``` and ```<br/>```, you should use: ```<br>```.
     */
    public static function stripTags (string $string, null|string|array $allowed_tags = null):string {

        return strip_tags($string, $allowed_tags);

    }

    /**
     * ### Unquotes a quoted string
     *
     * Backslashes are removed: (backslashes become single quote, double backslashes are made into a single backslash).
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be unquoted.
     * </p>
     *
     * @return string String with backslashes stripped off.
     *
     * @note StrSB#stripSlashes() is not recursive.<br>
     * If you want to apply this function to a multidimensional array, you need to use a recursive function.
     * @tip StrSB#stripSlashes() can be used if you aren't inserting this data into a place (such as a database)
     * that requires escaping.<br>
     * For example, if you're simply outputting data straight from an HTML form.
     */
    public static function stripSlashes (string $string):string {

        return stripslashes($string);

    }

    /**
     * ### Unquote string quoted with StrSB::addCSlashes
     *
     * Returns a string with backslashes stripped off. Recognizes C-like \n, \r ..., octal and hexadecimal
     * representation.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\StrSafe::stripSlashes() If $c_representation set to true.
     *
     * @param string $string <p>
     * The string to be unquoted.
     * </p>
     *
     * @return string The unescaped string.
     */
    public static function stripCSlashes (string $string):string {

        return stripcslashes($string);

    }

    /**
     * ### Split a string by a string
     *
     * Returns an array of strings, each of which is a substring of string formed by splitting it on boundaries
     * formed by the string separator.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Constants\Number\MAX To set the limit of returned array size to maximum.
     *
     * @param string $string <p>
     * The input string.
     * </p>
     * @param non-empty-string $separator <p>
     * The boundary string.
     * </p>
     * @param int<min, max> $limit [optional] <p>
     * If the limit is set and positive, the returned array will contain a maximum of limit elements with the last
     * element containing the rest of the string.<br>
     * If the limit parameter is negative, all components except the last – limit are returned.<br>
     * If the limit parameter is zero, then this is treated as 1.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\EmptySeparatorError If the separator is an empty string.
     *
     * @return ($string is empty ? list<string> : non-empty-list<string>) If a delimiter contains a value not contained
     * in string, and a negative limit is used, then an empty array will be returned. For any other limit, an array
     * containing a string will be returned.
     */
    public static function explode (string $string, string $separator, int $limit = MAX):array {

        try {

            return explode($separator, $string, $limit);

        } catch (ValueError) {

            throw new EmptySeparatorError;

        }

    }

    /**
     * ### Split a string into smaller chunks
     *
     * Can be used to split a string into smaller chunks, which is useful, for example, converting base64_encode()
     * output to match RFC 2045 semantics.<br>
     * It inserts $separator every $length characters.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be chunked.
     * </p>
     * @param positive-int $length [optional] <p>
     * The chunk length.
     * </p>
     * @param string $separator [optional] <p>
     * The line-ending sequence.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\ChunkLengthLessThanOneError If the length is less than 1.
     *
     * @return string The chunked string.
     */
    public static function chunkSplit (string $string, int $length = 76, string $separator = "\r\n"):string {

        return $length >= 1
            ? chunk_split($string, $length, $separator)
            : throw new ChunkLengthLessThanOneError;

    }

    /**
     * ### Pad a string to a certain length with another string
     *
     * This method returns the $string padded on the left, the right, or both sides to the specified padding length.<br>
     * If the optional argument $pad is not supplied, the $string is padded with spaces; otherwise it is padded with
     * characters from $pad up to the limit.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\Side::RIGHT If padding string to the right.
     * @uses \FireHub\Core\Shared\Enums\Side::LEFT If padding string to the left.
     * @uses \FireHub\Core\Shared\Enums\Side::BOTH If padding string on the both sides.
     *
     * @param string $string <p>
     * The string being padded.
     * </p>
     * @param int $length <p>
     * If the value of $length is negative, less than, or equal to the length of the input string, no padding takes
     * place.
     * </p>
     * @param non-empty-string $pad [optional] <p>
     * The pad may be truncated if the required number of padding characters can't be evenly divided by the pad's
     * length.
     * </p>
     * @param \FireHub\Core\Shared\Enums\Side $side [optional] <p>
     * Pad side.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\EmptyPadError If the pad is empty.
     *
     * @return string Padded string.
     */
    public static function pad (string $string, int $length, string $pad = " ", Side $side = Side::RIGHT):string {

        return $pad !== '' ? str_pad($string, $length, $pad, match ($side) {
            Side::LEFT => STR_PAD_LEFT,
            Side::RIGHT => STR_PAD_RIGHT,
            Side::BOTH => STR_PAD_BOTH
        }) : throw new EmptyPadError;

    }

    /**
     * ### Replace all occurrences of the search string with the replacement string
     *
     * This function returns a string or an array with all occurrences of search in a subject replaced with the given
     * replacement value.
     * @since 1.0.0
     *
     * @param string|list<string> $search <p>
     * The string being searched and replaced on.
     * </p>
     * @param string|list<string> $replace <p>
     * The replacement value that replaces found search values.<br>
     * An array may be used to designate multiple replacements.
     * </p>
     * @param string $string <p>
     * The value being searched for.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Searched values are case-insensitive.
     * </p>
     * @param null|int &$count [optional] <p>
     * If passed, this will hold the number of matched and replaced needles.
     * </p>
     * @param-out int $count
     *
     * @return string String with the replaced values.
     *
     * @note Because the method replaces left to right, it might replace a previously inserted value when doing
     * multiple replacements.
     * @tip To replace text based on a pattern rather than a fixed string, use preg_replace().
     */
    public static function replace (string|array $search, string|array $replace, string $string, bool $case_sensitive = true, ?int &$count = null):string {

        if ($case_sensitive) return str_replace($search, $replace, $string, $count);

        return str_ireplace($search, $replace, $string, $count);

    }

    /**
     * ### Replace text within a portion of a string
     *
     * Replaces a copy of string delimited by the $offset and (optionally) $length parameters with the string given
     * in $replace.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     * @param string $replace <p>
     * The replacement string.
     * </p>
     * @param int $offset <p>
     * If the offset is non-negative, the replacing will begin at the into string.<br>
     * If offset is negative, the replacing will begin at the character from the end of the string.
     * </p>
     * @param null|int $length [optional] <p>
     * If given and is positive, it represents the length of the portion of string which is to be replaced.<br>
     * If it is negative, it represents the number of characters from the end of the string at which to stop replacing.<br>
     * If it is not given, then it will default to StrSB#length(string); in other words, end the replacing at the
     * end of the string.<br>
     * Of course, if the length is zero, then this function will have the effect of inserting $replace into string
     * at the given offset.
     * </p>
     *
     * @return string String with the replaced values.
     */
    public static function replacePart (string $string, string $replace, int $offset, ?int $length = null):string {

        return substr_replace($string, $replace, $offset, $length);

    }

    /**
     * ### Randomly shuffles a string
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     *
     * @return ($string is empty ? '' : non-empty-string) The shuffled string.
     *
     * @caution This function doesn't generate cryptographically secure values and mustn't be used for cryptographic
     * purposes, or purposes that require returned values to be unguessable.
     */
    public static function shuffle (string $string):string {

        return str_shuffle($string);

    }

    /**
     * ### Reverse a string
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to be reversed.
     * </p>
     *
     * @return ($string is empty ? '' : non-empty-string) The reversed string.
     */
    public static function reverse (string $string):string {

        return strrev($string);

    }

    /**
     * ### Wraps a string to a given number of characters
     *
     * Wraps a string to a given number of characters using a string break character.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to warp.
     * </p>
     * @param int $width [optional] <p>
     * The column width.
     * </p>
     * @param string $break [optional] <p>
     * The line is broken using the optional break parameter.
     * </p>
     * @param bool $cut_long_words [optional] <p>
     * If the cut is set to true, the string is always wrapped at or before the specified width.<br>
     * So if you have a word that is larger than the given width, it is broken apart.
     * </p>
     *
     * @return string The given string wrapped at the specified column.
     */
    public static function wrap (string $string, int $width = 75, string $break = "\n", bool $cut_long_words = false):string {

        return wordwrap($string, $width, $break, $cut_long_words);

    }

    /**
     * ### Strip whitespace (or other characters) from the beginning and end of a string
     *
     * This function returns a string with whitespace stripped from the beginning and end of the string.<br>
     * Without the second parameter, StrSB#trim() will strip these characters.
     *
     * - " " (ASCII 32 (0x20)), an ordinary space.
     * - "\t" (ASCII 9 (0x09)), a tab.
     * - "\n" (ASCII 10 (0x0A)), a new line (line feed).
     * - "\r" (ASCII 13 (0x0D)), a carriage return.
     * - "\0" (ASCII 0 (0x00)), the NUL-byte.
     * - "\v" (ASCII 11 (0x0B)), a vertical tab.
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
     * @param string $characters [optional] <p>
     * The stripped characters can also be specified using the char-list parameter.<br>
     * List all characters that you want
     * to be stripped. With '..', you can specify a range of characters.
     * </p>
     *
     * @return string The trimmed string.
     *
     * @note Because StrSB#trim trims characters from the beginning and end of a string, it may be confusing when
     * characters are (or aren't) removed from the middle..<br>
     * StrSB#trim('abc', 'bad') removes both 'a' and 'b' because it trims 'a' thus moving 'b' to the beginning to
     * also be trimmed..<br>
     * So, this is why it "works" whereas StrSB#trim('abc', 'b') seemingly doesn't.
     */
    public static function trim (string $string, Side $side = Side::BOTH, string $characters = " \n\r\t\v\x00"):string {

        return match($side) {
            Side::LEFT => ltrim($string, $characters),
            Side::RIGHT => rtrim($string, $characters),
            Side::BOTH => trim($string, $characters)
        };

    }

    /**
     * ### Make a string lowercase
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being lowercased.
     * </p>
     *
     * @return ($string is empty ? '' : lowercase-string) String with all alphabetic characters converted to lowercase.
     */
    public static function toLower (string $string):string {

        return strtolower($string);

    }

    /**
     * ### Make a string uppercase
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being uppercased.
     * </p>
     *
     * @return ($string is empty ? '' : uppercase-string) String with all alphabetic characters converted to uppercase.
     */
    public static function toUpper (string $string):string {

        return strtoupper($string);

    }

    /**
     * ### Make a string title-cased
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being title cased.
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string) String with title-cased conversion.
     */
    public static function toTitle (string $string):string {

        return ucwords($string);

    }

    /**
     * ### Make the first character of a string uppercased
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being converted.
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string) String with the first character uppercased.
     */
    public static function capitalize (string $string):string {

        return ucfirst($string);

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
     * @return ($string is empty ? '' : non-falsy-string) String with the first character lowercased.
     */
    public static function deCapitalize (string $string):string {

        return lcfirst($string);

    }

    /**
     * ### String comparison
     * @since 1.0.0
     *
     * @param string $string_1 <p>
     * String to compare against.
     * </p>
     * @param string $string_2 <p>
     * String to compare with.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * Is comparison case-sensitive or not.
     * </p>
     *
     * @return int<-1, 1> -1 if string1 is less than string2; 1 if string1 is greater than string2, and 0 if they are
     * equal.
     *
     * @note This comparison is case-sensitive.
     */
    public static function compare (string $string_1, string $string_2, bool $case_sensitive = true):int {

        $cmp = $case_sensitive
            ? strcmp($string_1, $string_2)
            : strcasecmp($string_1, $string_2);

        return $cmp < 0 ? -1 : ($cmp > 0 ? 1 : 0);

    }

    /**
     * ### Comparison of two strings from an offset, up to length characters
     * @since 1.0.0
     *
     * @param string $string_1 <p>
     * String to compare against.
     * </p>
     * @param string $string_2 <p>
     * String to compare with.
     * </p>
     * @param int $offset <p>
     * The start position for the comparison.<br>
     * If negative, it starts counting from the end of the string.
     * </p>
     * @param null|int $length [optional] <p>
     * The length of the comparison.<br>
     * The default value is the largest of the length for the needle compared to the length of haystack minus the
     * offset.
     * </p>
     * @param bool $case_sensitive [optional] <p>
     * If case_sensitive is true, the comparison is case-sensitive.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\ComparePartError If $offset is higher than $string_1.
     *
     * @return int<-1, 1> -1 if string1 is less than string2, 1 if string1 is greater than string2, and zero if
     * they're equal.
     */
    public static function comparePart (string $string_1, string $string_2, int $offset, ?int $length = null, bool $case_sensitive = true):int {

        try {

            return substr_compare($string_1, $string_2, $offset, $length, !$case_sensitive) <=> 0;

        } catch (ValueError $error) {

            throw new ComparePartError($error->getMessage());

        }

    }

    /**
     * ### String comparison of the first n characters
     * @since 1.0.0
     *
     * @param string $string_1 <p>
     * String to compare against.
     * </p>
     * @param string $string_2 <p>
     * String to compare with.
     * </p>
     * @param int $length <p>
     * Number of characters to use in the comparison.
     * </p>
     *
     * @return int<-1, 1>|false -1 if string1 is less than string2; 1 if string1 is greater than string2, and 0 if
     * they are equal, or false if the length is less than 0.
     */
    public static function compareFirstN (string $string_1, string $string_2, int $length):int|false {

        $cmp = strncmp($string_1, $string_2, $length);

        return $length > 0 ? $cmp < 0 ? -1 : ($cmp > 0 ? 1 : 0) <=> 0 : false;

    }

    /**
     * ### Find the position of the first occurrence of a substring in a string
     * @since 1.0.0
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
     *
     * @return non-negative-int|false Numeric position of the first occurrence or false if none exist.
     *
     * @warning This function may return Boolean false but may also return a non-Boolean value which evaluates to false.<br>
     * Read the section on Booleans for more information.<br>
     * Use the === operator for testing the return value of this function.
     */
    public static function firstPosition (string $search, string $string, bool $case_sensitive = true, int $offset = 0):int|false {

        if ($case_sensitive) return strpos($string, $search, $offset);

        return stripos($string, $search, $offset);

    }

    /**
     * ### Find the position of the last occurrence of a substring in a string
     * @since 1.0.0
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
     *
     * @return non-negative-int|false Numeric position of the last occurrence or false if none exist.
     *
     * @warning This function may return Boolean false but may also return a non-Boolean value which evaluates to false.<br>
     * Read the section on Booleans for more information.<br>
     * Use the === operator for testing the return value of this function.
     */
    public static function lastPosition (string $search, string $string, bool $case_sensitive = true, int $offset = 0):int|false {

        if ($case_sensitive)
            /** @var non-negative-int|false */
            return strrpos($string, $search, $offset);

        /** @var non-negative-int|false */
        return strripos($string, $search, $offset);

    }

    /**
     * ### Translate characters or replace substrings
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being translated to.
     * </p>
     * @param array<non-empty-string, string> $replace_pairs <p>
     * An array of key-value pairs for translation.
     * </p>
     *
     * @return string The translated string.
     */
    public static function translate (string $string, array $replace_pairs):string {

        return strtr($string, $replace_pairs);

    }

    /**
     * ### Get part of string
     *
     * Returns the portion of the string specified by the $start and $length parameters.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to extract the substring from.
     * </p>
     * @param int $start <p>
     * If start is non-negative, the returned string will start at the start position in string, counting from zero.
     * For instance, in the string 'FireHub', the character at position 0 is 'F', the character at position 2 is 'r',
     * and so forth.<br>
     * If the start is negative, the returned string will start at the start character from the end of the string.
     * </p>
     * @param null|int $length [optional] <p>
     * Maximum number of characters to use from string.<br>
     * If omitted or NULL is passed, extract all characters to the end of the string.
     * </p>
     *
     * @return ($string is empty ? '' : string) The portion of string specified by the start and length parameters.
     */
    public static function part (string $string, int $start, ?int $length = null):string {

        return substr($string, $start, $length);

    }

    /**
     * ### Find the first occurrence of a string
     *
     * Returns part of $string starting from and including the first occurrence of $find to the end of $string.
     * @since 1.0.0
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
     * Searched values are case-insensitive.
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string)|false The portion of string or false if the $find
     * is not found.
     */
    public static function firstOccurrence (string $find, string $string, bool $before_needle = false, bool $case_sensitive = true):string|false {

        if ($case_sensitive) return strstr($string, $find, $before_needle);

        return stristr($string, $find, $before_needle);

    }

    /**
     * ### Finds the last occurrence of any character from $find within $string
     *
     * This function finds the last occurrence of a $find in the $string and returns the portion of $string.
     * @since 1.0.0
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
     *
     * @return ($string is empty ? '' : non-falsy-string)|false The portion of string, or false if the $find
     * is not found.
     */
    public static function lastCharacterFrom (string $find, string $string, bool $before_needle = false):string|false {

        return strrchr($string, $find, $before_needle);

    }

    /**
     * ### Find part of a string with characters
     * @since 1.0.0
     *
     * @param string $characters <p>
     * Characters to find. This parameter is case-sensitive.
     * </p>
     * @param string $string <p>
     * The string where characters are looked for.
     * </p>
     *
     * @return ($string is empty ? '' : non-falsy-string)|false String starting from the character found, or false if it
     * is not found.
     */
    public static function partFrom (string $characters, string $string):string|false {

        return strpbrk($string, $characters);

    }

    /**
     * ### Return information about characters used in a string
     *
     * Counts the number of occurrences for every byte-value (0..255) in $string and returns it in various ways.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Count\CharacterMode::ARR_POSITIVE As default parameter.
     *
     * @param string $string <p>
     * The examined string.
     * </p>
     * @param \FireHub\Core\Shared\Enums\String\Count\CharacterMode $mode [optional] <p>
     * Count mode.
     * </p>
     *
     * @return ($mode is CharacterMode::STR_* ? string : array<int, int>) An array with the byte-value as a key with a
     * frequency greater than zero are listed.
     *
     * @phpstan-ignore-next-line return.unusedType
     */
    public static function countByChar (string $string, CharacterMode $mode = CharacterMode::ARR_POSITIVE):string|array {

        return count_chars($string, $mode->value);

    }

    /**
     * ### Convert a string to an array
     * @since 1.0.0
     *
     * @param string $string <p>
     * The input string.
     * </p>
     * @param positive-int $length [optional] <p>
     * Maximum length of the chunk.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\ChunkLengthLessThanOneError If the length is less than 1.
     *
     * @return list<non-empty-string> If the optional $length parameter is specified, the returned array will be broken
     * down into chunks with each being $length in length, except the final chunk which may be shorter if the string
     * doesn't divide evenly.<br>
     * The default $length is 1, meaning every chunk will be one byte in size.
     */
    public static function split (string $string, int $length = 1):array {

        return $length >= 1
            ? str_split($string, $length)
            : throw new ChunkLengthLessThanOneError;

    }

    /**
     * ### Count the number of words in a string
     *
     * Counts the number of words inside a string.<br>
     * If the optional format is not specified, then the return value will be an integer representing the number of
     * words found..<br>
     * In the event the format is specified, the return value will be an array, the content of which is dependent on
     * the format..<br>
     * The possible value for the format and the resultant outputs are listed below.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\Count\WordFormat::WORDS As default parameter.
     *
     * @param string $string <p>
     * The string.
     * </p>
     * @param null|string $characters [optional] <p>
     * A list of additional characters which will be considered as 'word'.
     * </p>
     * @param \FireHub\Core\Shared\Enums\String\Count\WordFormat $format [optional] <p>
     * Word count format for strings.
     * </p>
     *
     * @return int|array<int, string> Number of words found or list of words.
     */
    public static function countWords (string $string, ?string $characters = null, WordFormat $format = WordFormat::WORDS):int|array {

        /** @var int|array<int, string> */
        return str_word_count($string, $format->value, $characters);

    }

    /**
     * ### Get the number of times the searched substring occurs in the string
     *
     * Returns the number of times the needle substring occurs in the haystack string.<br>
     * Note that the needle is case-sensitive.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being checked.
     * </p>
     * @param string $search <p>
     * The string being found.
     * </p>
     * @param int $start [optional] <p>
     * The offset is where to start counting.<br>
     * If the offset is negative, counting starts from the end of the string.
     * </p>
     * @param null|int $length [optional] <p>
     * The maximum length after the specified offset to search for the substring.<br>
     * It outputs a warning if the offset plus the length is greater than the $string length.<br>
     * A negative length counts from the end of $string.
     * </p>
     *
     * @return non-negative-int The number of times the searched substring occurs in the string.
     *
     * @note This method doesn't count overlapped substring.
     */
    public static function partCount (string $string, string $search, int $start = 0, ?int $length = null):int {

        return substr_count($string, $search, $start, $length);

    }

    /**
     * ### Length of the initial segment for a string consisting entirely of characters contained within a given mask
     *
     * Finds the length of the initial segment for $string that contains only characters from $characters.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to examine.
     * </p>
     * @param string $characters <p>
     * The list of allowable characters.
     * </p>
     * @param int $offset [optional] <p>
     * The position in a subject to start searching.<br>
     * If start is given and is non-negative, then StrSB#segmentMatching() will begin examining the subject at
     * the start position.<br>
     * For instance, in the string 'abcdef', the character at position 0 is 'a', the character at position 2 is 'c',
     * and so forth.<br>
     * If start is given and is negative, then StrSB#segmentMatching() will begin examining the subject at the start
     * position from the end of a subject.
     * </p>
     * @param int|null $length [optional] <p>
     * The length of the segment from the subject to examine.<br>
     * If length is given and is non-negative, then the subject will be examined for length characters after the
     * starting position.<br>
     * If length is given and is negative, then the subject will be examined from the starting position up-to-length
     * characters from the end of the subject.
     * </p>
     *
     * @return non-negative-int The length of the initial segment for string which consists entirely of characters in
     * characters.
     *
     * @note When the offset parameter is set, the returned length is counted starting from this position, not from
     * beginning of the string.
     */
    public static function segmentMatching (string $string, string $characters, int $offset = 0, ?int $length = null):int {

        return strspn($string, $characters, $offset, $length);

    }

    /**
     * ### Find length of the initial segment not matching mask
     *
     * Returns the length of the initial segment for $string which doesn't contain any of the characters in $characters.
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string to examine.
     * </p>
     * @param string $characters <p>
     * The string containing every disallowed character.
     * </p>
     * @param int $offset [optional] <p>
     * The position in a subject to start searching.<br>
     * If start is given and is non-negative, then StrSB#segmentNotMatching() will begin examining the subject at
     * the start position.<br>
     * For instance, in the string 'abcdef', the character at position 0 is 'a', the character at position 2 is 'c',
     * and so forth.<br>
     * If start is given and is negative, then StrSB#segmentNotMatching() will begin examining the subject at the
     * start position from the end of a subject.
     * </p>
     * @param null|int $length [optional] <p>
     * The length of the segment from the subject to examine.<br>
     * If length is given and is non-negative, then the subject will be examined for length characters after the
     * starting position.<br>
     * If length is given and is negative, then the subject will be examined from the starting position up-to-length
     * characters from the end of the subject.
     * </p>
     *
     * @return non-negative-int The length of the initial segment from string which consists entirely of characters not
     * in characters.
     *
     * @note When the offset parameter is set, the returned length is counted starting from this position, not from
     * beginning of the string.
     */
    public static function segmentNotMatching (string $string, string $characters, int $offset = 0, ?int $length = null):int {

        return strcspn($string, $characters, $offset, $length);

    }

    /**
     * ### Get string length
     * @since 1.0.0
     *
     * @param string $string <p>
     * The string being measured for length.
     * </p>
     *
     * @return non-negative-int String length.
     *
     * @note The function returns the number of bytes rather than the number of characters in a string.
     */
    public static function length (string $string):int {

        return strlen($string);

    }

}