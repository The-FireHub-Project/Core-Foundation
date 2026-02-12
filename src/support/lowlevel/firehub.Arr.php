<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.4
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Shared\Enums\String\CaseFolding;
use FireHub\Core\Throwable\Error\LowLevel\Arr\ {
    ChunkLengthTooSmallError, FailedToSortMultiArrayError, KeysAndValuesDiffNumberOfElemsError, OutOfRangeError,
    SizeInconsistentError
};
use ValueError;

use const FireHub\Core\Shared\Constants\Number\MAX_32_BIT;

use function array_all;
use function array_any;
use function array_change_key_case;
use function array_chunk;
use function array_column;
use function array_combine;
use function array_count_values;
use function array_diff;
use function array_diff_assoc;
use function array_diff_key;
use function array_diff_uassoc;
use function array_diff_ukey;
use function array_fill;
use function array_fill_keys;
use function array_filter;
use function array_find;
use function array_find_key;
use function array_first;
use function array_flip;
use function array_intersect;
use function array_intersect_assoc;
use function array_intersect_key;
use function array_intersect_uassoc;
use function array_intersect_ukey;
use function array_is_list;
use function array_key_exists;
use function array_key_first;
use function array_key_last;
use function array_keys;
use function array_last;
use function array_map;
use function array_merge;
use function array_merge_recursive;
use function array_multisort;
use function array_pad;
use function array_pop;
use function array_product;
use function array_push;
use function array_rand;
use function array_reduce;
use function array_replace;
use function array_replace_recursive;
use function array_reverse;
use function array_search;
use function array_shift;
use function array_slice;
use function array_splice;
use function array_sum;
use function array_udiff;
use function array_udiff_assoc;
use function array_udiff_uassoc;
use function array_uintersect;
use function array_uintersect_assoc;
use function array_uintersect_uassoc;
use function array_unique;
use function array_unshift;
use function array_values;
use function array_walk;
use function array_walk_recursive;
use function arsort;
use function asort;
use function rsort;
use function in_array;
use function krsort;
use function ksort;
use function range;
use function shuffle;
use function sort;
use function uasort;
use function uksort;
use function usort;

/**
 * ### Array low-level proxy class
 *
 * Low-level proxy for PHP array functions; defensive, JIT-friendly, and deterministic. Replicates native behavior
 * without throwing exceptions, serving as a foundation for high-level array/collection operations.
 * @since 1.0.0
 *
 * @internal
 */
final class Arr {

    /**
     * ### Checks if all array elements satisfy a callback function
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * The array that should be searched.
     * </p>
     * @param callable(TValue, TKey):bool $callback <p>
     * The callback function to call to check each element.
     * </p>
     *
     * @return bool True if callback returns true for all elements, false otherwise.
     */
    public static function all (array $array, callable $callback):bool {

        return array_all($array, $callback);

    }

    /**
     * ### Checks if at least one array element satisfies a callback function
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * The array that should be searched.
     * </p>
     * @param callable(TValue, TKey):bool $callback <p>
     * The callback function to call to check each element.
     * </p>
     *
     * @return bool True if there is at least one element for which callback returns true, false otherwise.
     */
    public static function any (array $array, callable $callback):bool {

        return array_any($array, $callback);

    }

    /**
     * ### Checks if the given key or index exists in the array
     *
     * Returns true if the given key is set in the array.
     * Key can be any value possible for an array index.
     * @since 1.0.0
     *
     * @template TKey of array-key
     *
     * @param TKey $key <p>
     * Key to check.
     * </p>
     * @param array<array-key, mixed> $array <p>
     * An array with keys to check.
     * </p>
     *
     * @phpstan-assert-if-true array<TKey, mixed> $array
     *
     * @return bool True if the key exists in an array, false otherwise.
     *
     * @note Method will search for the keys in the first dimension only.
     * Nested keys in multidimensional arrays will not be found.
     */
    public static function keyExist (int|string $key, array $array):bool {

        return array_key_exists($key, $array);

    }

    /**
     * ### Checks if a value exists in an array
     * @since 1.0.0
     *
     * @template TValue
     *
     * @param array<array-key, TValue> $array <p>
     * The array.
     * </p>
     * @param mixed $value <p>
     * The searched value.
     * If the value is a string, the comparison is done in a case-sensitive manner.
     * </p>
     *
     * @phpstan-assert-if-true TValue $value
     *
     * @return bool True if a value is found in the array, false otherwise.
     */
    public static function inArray (array $array, mixed $value):bool {

        return in_array($value, $array, true);

    }

    /**
     * ### Checks whether a given array is a list
     *
     * Determines if the given array is a list.
     * An array is considered a list if its keys consist of consecutive numbers from 0 to count($array)-1.
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array <p>
     * The array is being evaluated.
     * </p>
     *
     * @phpstan-assert-if-true list<mixed> $array
     *
     * @return ($array is list ? true : false) True if an array is a list, false otherwise.
     *
     * @note This function returns true on empty arrays.
     */
    public static function isList (array $array):bool {

        return array_is_list($array);

    }

    /**
     * ### Sort multiple on multidimensional arrays
     * @since 1.0.0
     *
     * @param array<array-key, array<array-key, mixed>> &$array <p>
     * A multidimensional array being sorted.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\FailedToSortMultiArrayError Failed to sort a multi-sort array.
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\SizeInconsistentError If array sizes are inconsistent.
     *
     * @return true True on success.
     *
     * @caution Associative (string) keys will be maintained, but numeric keys will be re-indexed.
     * @note Resets array's internal pointer to the first element.
     */
    public static function multiSort (array &$array):true {

        try {

            return array_multisort(...$array) // @phpstan-ignore ternary.alwaysTrue
                ?: throw new FailedToSortMultiArrayError;

        } catch (ValueError) {

            throw new SizeInconsistentError;

        }

    }

    /**
     * ### Apply a user function to every member of an array
     *
     * Applies the user-defined callback function to each element of the array $array.<br>
     * Method is not affected by the internal array pointer of an array.<br>
     * Method will walk through the entire array regardless of pointer position.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     * @template TReturn
     *
     * @param array<TKey, TValue> &$array <p>
     * The array to apply a user function.
     * </p>
     * @param callable(TValue, TKey):TReturn $callback <p>
     * Typically, the function name takes on two parameters.<br>
     * The array parameter's value is the first, and the key/index second.<br>
     * If a function name needs to be working with the actual values of the array, specify the first parameter of the
     * function name as a reference.<br>
     * Then, any changes made to those elements will be made in the original array itself.<br>
     * Users may not change the array itself from the callback function, for example, add/delete elements, unset
     * elements, and so on.<br>
     * </p>
     * @phpstan-param-out array<TKey, TReturn> $array
     *
     * @return true True on success.
     */
    public static function walk (array &$array, callable $callback):true {

        return array_walk($array, $callback); // @phpstan-ignore paramOut.type

    }

    /**
     * ### Apply a user function recursively to every member of an array
     *
     * Applies the user-defined callback function to each element of the array.<br>
     * This function will recurse into deeper arrays.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     * @template TReturn
     *
     * @param array<TKey, TValue> &$array <p>
     * The array to apply a user function.
     * </p>
     * @param callable(TValue, TKey):TReturn $callback <p>
     * Typically, the function name takes on two parameters.<br>
     * The array parameter's value is the first, and the key/index second.<br>
     * If a function name needs to be working with the actual values of the array, specify the first parameter of the
     * function name as a reference.<br>
     * Then, any changes made to those elements will be made in the original array itself.<br>
     * Users may not change the array itself from the callback function.<br>
     * For example, Add/delete elements, unset elements, and so on.<br>
     * </p>
     * @phpstan-param-out array<TKey, TReturn> $array
     *
     * @return true True on success.
     */
    public static function walkRecursive (array &$array, callable $callback):true {

        return array_walk_recursive($array, $callback); // @phpstan-ignore paramOut.type

    }

    /**
     * ### Counts the occurrences of each distinct value in an array
     *
     * Returns an array using the values of $array (which must be int-s or strings) as keys and their frequency in an
     * $array as values.
     * @since 1.0.0
     *
     * @template TValue of array-key
     *
     * @param array<array-key, TValue> $array <p>
     * The array of values to count.
     * </p>
     *
     * @return array<TValue, positive-int> An associative array of values from input as keys and their count as
     * value.
     */
    public static function countValues (array $array):array {

        return array_count_values($array);

    }

    /**
     * ### Fill an array with values
     *
     * Fills an array with $length entries of the value for the $value parameter, keys starting at the $start_index
     * parameter.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Constants\Number\MAX_32_BIT As maximum length for $length parameter.
     *
     * @template TValue
     *
     * @param TValue $value <p>
     * Value to use for filling.
     * </p>
     * @param int $start_index <p>
     * The first index of the returned array.
     * </p>
     * @param int<0, 2147483647> $length <p>
     * Number of elements to insert. Must be greater than or equal to zero.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\OutOfRangeError If $length is out of range.
     *
     * @return array<int, TValue> Filled array.
     */
    public static function fill (mixed $value, int $start_index, int $length):array {

        return !($length < 0) && !($length >= MAX_32_BIT)
            ? array_fill($start_index, $length, $value)
            : throw new OutOfRangeError;

    }

    /**
     * ### Fill an array with values, specifying keys
     *
     * Fills an array with the value of the $value parameter, using the values of the $keys array as keys.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<array-key, TKey> $keys <p>
     * Array of values that will be used as keys.<br>
     * Illegal values for a key will be converted to string.
     * </p>
     * @param TValue $value <p>
     * Value to use for filling.
     * </p>
     *
     * @return array<TKey, TValue> The filled array.
     */
    public static function fillKeys (array $keys, mixed $value):array {

        return array_fill_keys($keys, $value);

    }

    /**
     * ### Changes the case of all keys in an array
     *
     * Returns an array with all keys from an array lowercased or uppercased.
     * Numbered indices are left as is.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\String\CaseFolding::LOWER As default parameter.
     * @uses \FireHub\Core\Shared\Enums\String\CaseFolding::UPPER To fold keys to uppercase.
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * The array to work on.
     * </p>
     * @param (\FireHub\Core\Shared\Enums\String\CaseFolding::LOWER|\FireHub\Core\Shared\Enums\String\CaseFolding::UPPER) $case [optional] <p>
     * Either LOWER or UPPER case folding.
     * </p>
     *
     * @return array<TKey, TValue> An array with its keys lower or uppercased.
     */
    public static function foldKeys (array $array, CaseFolding $case = CaseFolding::LOWER):array {

        return array_change_key_case($array, $case === CaseFolding::UPPER ? CASE_UPPER : CASE_LOWER);

    }

    /**
     * ### Split an array into chunks
     *
     * Chunks an array into arrays with $length elements.<br>
     * The last chunk may contain less than $length elements.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue> $array <p>
     * The array.
     * </p>
     * @param positive-int $length <p>
     * The size of each chunk.
     * If the length is less than 1, it will default to 1.
     * </p>
     * @param bool $preserve_keys [optional] <p>
     * When set to true, keys will be preserved.<br>
     * Default is false that will reindex the chunk numerically.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\ChunkLengthTooSmallError If the length is less than 1.
     *
     * @return ($preserve_keys is true ? list<array<TKey, TValue>> : list<list<TValue>>) Multidimensional numerically
     * indexed array, starting with zero, with each dimension contains $length elements.
     */
    public static function chunk (array $array, int $length, bool $preserve_keys = false):array {

        return !($length < 1)
            ? array_chunk($array, $length, $preserve_keys)
            : throw new ChunkLengthTooSmallError;

    }

    /**
     * ### Return the values from a single column in the input array
     *
     * Returns the values from a single column of the $array, identified by the $key.<br>
     * Optionally, an argument key may be provided to $index the values in the returned array by the values from the
     * index argument column of the input array.
     * @since 1.0.0
     *
     * @template TColumn of array-key
     * @template TIndex of null|array-key
     * @template TArray of array<array-key, mixed>
     *
     * @param array<array-key, TArray> $array <p>
     * A multidimensional array (record set) from which to pull a column of values.<br>
     * If an array of objects is provided, then public properties can be directly pulled.<br>
     * In order for protected or private properties to be pulled, the class must implement both the __get() and
     * __isset() magic methods.<br>
     * </p>
     * @param TColumn $key <p>
     * The column of values to return.<br>
     * This value may be an integer key of the column you wish to retrieve, or it may be a string key name for an
     * associative array or property name.<br>
     * It may also be null to return complete arrays or objects (this is useful together with $index to reindex the
     * array).<br>
     * </p>
     * @param TIndex $index [optional] <p>
     * The column to use as the index/keys for the returned array.<br>
     * This value may be the integer key of the column, or it may be the string key name.<br>
     * The value is cast as usual for array keys.
     * </p>
     *
     * @return ($index is null ? list{TArray[TColumn]} : array{TArray[TIndex], TArray[TColumn]}) Array of values
     * representing a single column from the input array.
     */
    public static function column (array $array, int|string $key, null|int|string $index = null):array {

        /** @var ($index is null ? list{TArray[TColumn]} : array{TArray[TIndex], TArray[TColumn]}) */
        return array_column($array, $key, $index);

    }

    /**
     * ### Creates an array by using one array for keys and another for its values
     *
     * Creates an array by using the values from the $keys array as keys and the values from the $values array as the
     * corresponding values.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<array-key, TKey> $keys <p>
     * Array of values to be used as keys.<br>
     * Illegal values for a key will be converted to string.
     * </p>
     * @param array<array-key, TValue> $values <p>
     * Array of values to be used as values on a combined array.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\KeysAndValuesDiffNumberOfElemsError If arguments $keys and
     * $values don't have the same number of elements.
     *
     * @return array<TKey, TValue> The combined array.
     */
    public static function combine (array $keys, array $values):array {

        try {

            return array_combine($keys, $values);

        } catch (ValueError) {

            throw new KeysAndValuesDiffNumberOfElemsError;

        }

    }

    /**
     * ### Computes the difference of arrays using values for comparison
     *
     * Compares an array against one or more other arrays and returns the values in an array that aren't present in any
     * of the other arrays.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param array<array-key, mixed> ...$excludes [optional] <p>
     * An array to compare against.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of the other arrays.
     *
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * You can check deeper dimensions by using {@see Arr#difference($array1[0], $array2[0])}.
     */
    public static function difference (array $array, array ...$excludes):array {

        /** @var TArray */
        return array_diff($array, ...$excludes);

    }

    /**
     * ### Computes the difference of arrays using values for comparison by using a callback for comparison
     *
     * Computes the difference of arrays by using a callback function for data comparison.<br>
     * This is unlike {@see Arr#difference()} which uses an internal function for comparing the data.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function must return an integer less than, equal to, or greater than zero if the first argument
     * is considered to be respectively less than, equal to, or greater than the second.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of
     * the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note Note that this function only checks one dimension of an n-dimensional array.<br>
     * Of course, you can check deeper dimensions by using
     * {@see Arr#differenceFunc($array1[0], $array2[0]), 'data_compare_func')}.
     */
    public static function differenceFunc (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_udiff($array, $excludes, $callback);

    }

    /**
     * ### Computes the difference of arrays using keys for comparison
     *
     * Compares the keys from an array against the keys from arrays and returns the difference.
     * This function is like {@see Arr#difference()} except the comparison is done on the keys instead of the values.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param array<array-key, mixed> ...$excludes [optional] <p>
     * An array to compare against.
     * </p>
     *
     * @return TArray Returns an array containing all the entries from an array whose keys are absent from all the
     * other arrays.
     *
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * Of course, you can check deeper dimensions by using {@see Arr#differenceKey($array1[0], $array2[0])}.
     */
    public static function differenceKey (array $array, array ...$excludes):array {

        /** @var TArray */
        return array_diff_key($array, ...$excludes);

    }

    /**
     * ### Computes the difference of arrays using keys for comparison by using a callback for data comparison
     *
     * Compares the keys from an array against the keys from arrays and returns the difference.<br>
     * This function is like {@see Arr#difference()} except the comparison is done on the keys instead of the values.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * Of course, you can check deeper dimensions by using
     * {@see Arr#differenceKeyFunc($array1[0], $array2[0], 'callback_func')}.
     */
    public static function differenceKeyFunc (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_diff_ukey($array, $excludes, $callback);

    }

    /**
     * ### Computes the difference of arrays with additional index check
     *
     * Compares an array against arrays and returns the difference.<br>
     * Unlike {@see Arr#difference()}, the array keys are also used in the comparison.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param array<array-key, mixed> ...$excludes [optional] <p>
     * An array to compare against.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of
     * the other arrays.
     *
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * It is possible to check deeper dimensions by using, for example,
     * {@see Arr#differenceAssoc($array1[0], $array2[0])}.
     * @note Ensure arguments are passed in the correct order when comparing similar arrays with more keys.<br>
     * The new array should be the first in the list.
     */
    public static function differenceAssoc (array $array, array ...$excludes):array {

        /** @var TArray */
        return array_diff_assoc($array, ...$excludes);

    }

    /**
     * ### Computes the difference of arrays with additional index check by using a callback for value comparison
     *
     * Computes the difference of arrays with an additional index check, compares data by a callback function.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note Note that this function only checks one dimension of an n-dimensional array.<br>
     * Of course, you can check deeper dimensions by using, for example,
     * {@see Arr#differenceAssocFuncValue($array1[0], $array2[0], some_comparison_func')}.
     */
    public static function differenceAssocFuncValue (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_udiff_assoc($array, $excludes, $callback);

    }

    /**
     * ### Computes the difference of arrays with additional index check by using a callback for key comparison
     *
     * Compares an array against arrays and returns the difference.<br>
     * Unlike {@see Arr#difference()}, the array keys are used in the comparison.<br>
     * Unlike {@see Arr#differenceAssoc()}, a user-supplied callback function is used for the indices' comparison,
     * not an internal function.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray Returns an array containing all the entries from $array that aren't present in any of the other
     * arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * It is possible to check deeper dimensions by using, for example,
     * {@see Arr#differenceAssocFuncKey($array1[0], $array2[0], 'key_compare_func')}.
     */
    public static function differenceAssocFuncKey (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_diff_uassoc($array, $excludes, $callback);

    }

    /**
     * ### Computes the difference of arrays with additional index check by using a callback for key-value comparison
     *
     * Computes the difference of arrays with additional index check, compares data, and indexes by a callback function.<br>
     * Note that the keys are used in the comparison unlike {@see Arr#difference()} and {@see Arr#differenceFunc()}.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback_value <p>
     * The comparison function for value.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1> $callback_key <p>
     * The comparison function for a key.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that aren't present in any of
     * the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note This function only checks one dimension of an n-dimensional array.<br>
     * It is possible to check deeper dimensions by using, for example,
     * {@see Arr#differenceAssocFuncKeyValue($array1[0], $array2[0], 'data_compare_func', 'key_compare_func')}.
     */
    public static function differenceAssocFuncKeyValue (array $array, array $excludes, callable $callback_value, callable $callback_key):array {

        /** @var TArray */
        return array_udiff_uassoc($array, $excludes, $callback_value, $callback_key);

    }

    /**
     * ### Computes the intersection of arrays using values for comparison
     *
     * Returns an array containing all the values of an array that are present in all the arguments.<br>
     * Note that keys are preserved.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array with main values to check.
     * </p>
     * @param array<array-key, mixed> ...$arrays [optional] <p>
     * An array to compare values against.
     * </p>
     *
     * @return TArray The filtered array.
     *
     * @note Two elements are considered equal if and only if (string) $elem1 === (string) $elem2.<br>
     * In words: when the string representation is the same.
     */
    public static function intersect (array $array, array ...$arrays):array {

        /** @var TArray */
        return array_intersect($array, ...$arrays);

    }

    /**
     * ### Computes the intersection of arrays using values for comparison by using a callback for data comparison
     *
     * Computes the intersection of arrays, compares data by a callback function.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray Arrays containing all the entries from $array that are present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note Two elements are considered equal if and only if (string) $elem1 === (string) $elem2.<br>
     * In words: when the string representation is the same.
     */
    public static function intersectFunc (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_uintersect($array, $excludes, $callback);

    }

    /**
     * ### Computes the intersection of arrays using keys for comparison
     *
     * Returns an array containing all the entries of an array which have keys that are present in all the arguments.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array with main values to check.
     * </p>
     * @param array<array-key, mixed> ...$arrays [optional] <p>
     * An array to compare values against.
     * </p>
     *
     * @return TArray The filtered array.
     */
    public static function intersectKey (array $array, array ...$arrays):array {

        return array_intersect_key($array, ...$arrays);

    }

    /**
     * ### Computes the intersection of arrays using keys for comparison by using a callback for data comparison
     *
     * Returns an array containing all the values of an array which have matching keys that are present in all the
     * arguments.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that are present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     */
    public static function intersectKeyFunc (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_intersect_ukey($array, $excludes, $callback);

    }

    /**
     * ### Computes the intersection of arrays with additional index check
     *
     * Returns an array containing all the values of an array that are present in all the arguments.<br>
     * Note that the keys are also used in the comparison, unlike in {@see Arr#intersect()}.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array with main values to check.
     * </p>
     * @param array<array-key, mixed> ...$arrays [optional] <p>
     * An array to compare values against.
     * </p>
     *
     * @return TArray The filtered array.
     *
     * @note The two values from the key → value pairs are considered equal only if (string) $elem1 === (string) $elem2.<br>
     * In other words, a strict type check is executed, so the string representation must be the same.
     */
    public static function intersectAssoc (array $array, array ...$arrays):array {

        /** @var TArray */
        return array_intersect_assoc($array, ...$arrays);

    }

    /**
     * ### Computes the intersection of arrays with additional index check by using a callback for value comparison
     *
     * Computes the intersection of arrays with additional index check, compares data by a callback function.<br>
     * Note that the keys are used in the comparison unlike in {@see Arr#intersectFunc()}.
     * The data is compared by using a callback function.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that are present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     */
    public static function intersectAssocFuncValue (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_uintersect_assoc($array, $excludes, $callback);

    }

    /**
     * ### Computes the intersection of arrays with additional index check by using a callback for key comparison
     *
     * Computes the intersection of arrays with additional index check, compares data and indexes by separate
     * callback functions.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1> $callback <p>
     * The comparison function.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that are present in any of the other arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note The comparison function must return an integer less than, equal to, or greater than zero if<br>
     * the first argument is considered to be respectively less than, equal to, or greater than the second.
     */
    public static function intersectAssocFuncKey (array $array, array $excludes, callable $callback):array {

        /** @var TArray */
        return array_intersect_uassoc($array, $excludes, $callback);

    }

    /**
     * ### Computes the intersection of arrays with additional index check by using a callback for key-value comparison
     *
     * Computes the intersection of arrays with additional index check, compares data and indexes by separate
     * callback functions.
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     * @template TCompareArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * The array to compare from.
     * </p>
     * @param TCompareArray $excludes <p>
     * An array to compare against.
     * </p>
     * @param callable(value-of<TArray>|value-of<TCompareArray>, value-of<TArray>|value-of<TCompareArray>):int<-1, 1> $callback_value <p>
     * The comparison function for value.
     * </p>
     * @param callable(key-of<TArray>|key-of<TCompareArray>, key-of<TArray>|key-of<TCompareArray>):int<-1, 1>  $callback_key <p>
     * The comparison function for a key.
     * </p>
     *
     * @return TArray An array containing all the entries from $array that are present in any of the other
     * arrays.
     *
     * @caution Returning non-integer values from the comparison function, such as float, will result in an internal
     * cast to int of the callback's return value.<br>
     * So values such as 0.99 and 0.1 will both be cast to an integer value of 0, which will compare such values as
     * equal.
     * @note The comparison function must return an integer less than, equal to, or greater than zero if
     * the first argument is considered to be respectively less than, equal to, or greater than the second.
     */
    public static function intersectAssocFuncKeyValue (array $array, array $excludes, callable $callback_value, callable $callback_key):array {

        /** @var TArray */
        return array_uintersect_uassoc($array, $excludes, $callback_value, $callback_key);

    }

}