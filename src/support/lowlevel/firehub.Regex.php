<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;
use FireHub\Core\Throwable\Error\LowLevel\Regex\InvalidPatternError;

use function preg_match;
use function preg_match_all;

/**
 * ### Regex low-level proxy class
 *
 * The syntax for patterns used in these functions closely resembles Perl.<br>
 * The expression must be enclosed in the delimiters, a forward slash (/), for example.<br>
 * Delimiters can be any non-alphanumeric, non-whitespace ASCII character except the backslash (\) and the null byte.<br>
 * If the delimiter character has to be used in the expression itself, it needs to be escaped by backslash.<br>
 * Perl style (), {}, [], and <> matching delimiters may also be used.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class Regex extends LowLevel {

    /**
     * ### Perform a regular expression match
     *
     * Searches subject for a match to the regular expression given in a pattern.
     * @since 1.0.0
     *
     * @param string $pattern <p>
     * The regular expression pattern.
     * </p>
     * @param string $string <p>
     * The string being evaluated.
     * </p>
     * @param int $offset [optional] <p>
     * Normally, the search starts from the beginning of the subject string.<br>
     * The optional parameter offset can be used to specify the alternate place from which to start the search (in
     * bytes).
     * </p>
     * @param bool $all [optional] <p>
     * If true, search subject for a match to the regular expression given in a pattern.
     * </p>
     * @param null|string[] &$result [optional] <p>
     * Regular expressions match the result.
     * </p>
     * @param-out array<string>|array<array<int, string>> $result
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Regex\InvalidPatternError If the regular expression pattern is
     * invalid.
     *
     * @return bool True if the string matches the regular expression pattern, false if not.
     *
     * @warning This function may return Boolean false but may also return a non-Boolean value which evaluates to false.
     * Read the section on Booleans for more information.<br>
     * Use the === operator for testing the return value of this function.
     */
    public static function match (string $pattern, string $string, int $offset = 0, bool $all = false, ?array &$result = null):bool {

        $match = $all
            ? @preg_match_all($pattern, $string, $result, offset: $offset)
            : @preg_match($pattern, $string, $result, offset: $offset);

        return $match === false
            ? throw new InvalidPatternError
            : $match !== 0;

    }

}