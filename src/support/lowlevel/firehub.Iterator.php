<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.2
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;
use Traversable;

use function iterator_apply;
use function iterator_count;
use function iterator_to_array;

/**
 * ### Iterator low-level proxy class
 *
 * Provides low-level utilities for working with array internal pointers and iterable traversal.<br>
 * This class exposes thin wrappers around native PHP pointer-based iteration functions, ensuring consistent API
 * usage and static analysis compatibility within FireHub.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class Iterator extends LowLevel {

    /**
     * ### Copy the iterator into an array
     *
     * Copy the elements of an iterator into an array.
     * @since 1.0.0
     *
     * @template TKey of array-key
     * @template TValue
     *
     * @param iterable<TKey, TValue> $iterator <p>
     * The iterator being copied.
     * </p>
     * @param bool $preserve_keys [optional] <p>
     * Whether to use the iterator element keys as index.<br>
     * If a key is an array or object, a warning will be generated.<br>
     * Null keys will be converted to an empty string, float keys will be truncated to their int counterpart,
     * resource keys will generate a warning and be converted to their resource ID, and bool keys will be converted
     * to integers.
     * </p>
     *
     * @return ($preserve_keys is true ? array<TKey, TValue> : list<TValue>) An array containing items of the iterator.
     *
     * @note If this parameter $preserve_keys is not set or set to true, duplicate keys will be overwritten.<br>
     * The last value with a given key will be in the returned array.<br>
     * Set this parameter as false to get all the values in any case.
     */
    public static function toArray (iterable $iterator, bool $preserve_keys = true):array {

        return iterator_to_array($iterator, $preserve_keys);

    }

    /**
     * ### Count the elements in an iterator
     *
     * Count the elements in an iterator.<br>
     * Method is not guaranteed to retain the current position of the iterator.
     * @since 1.0.0
     *
     * @param iterable<mixed, mixed> $iterator <p>
     * The iterator being counted.
     * </p>
     *
     * @return non-negative-int Number of elements in iterator.
     */
    public static function count (iterable $iterator):int {

        return iterator_count($iterator);

    }

    /**
     * ### Call a function for every element in an iterator
     * @since 1.0.0
     *
     * @template TKey
     * @template TValue
     *
     * @param Traversable<TKey, TValue> $iterator <p>
     * The iterator objects to iterate over.
     * </p>
     * @param callable(mixed...):bool $callback <p>
     * The callback function to call on every element.<br>
     * The function must return true to continue iterating over the iterator.
     * </p>
     * @param null|array<array-key, mixed> $arguments <p>
     * An array of arguments; each element of args is passed to the callback as a separate argument.
     * </p>
     *
     * @return int Iteration count.
     */
    public static function apply (Traversable $iterator, callable $callback, ?array $arguments = null):int {

        return iterator_apply($iterator, $callback, $arguments);

    }

}