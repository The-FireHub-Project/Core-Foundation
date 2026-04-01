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

namespace FireHub\Core\Support\DataStructure\Contracts\Capability;

/**
 * ### Transformable Data Structure Capability
 *
 * Provides a functional transformation contract for data structures, enabling value-level operations such as mapping
 * and reduction without altering the underlying structural semantics.<br>
 * This capability focuses on immutable-style transformations, where operations produce derived results or new
 * instances rather than mutating the original structure. It is designed to be composable across different
 * data structure types, including collections, graphs, and other iterable forms, as long as a deterministic
 * traversal can be established.<br>
 * Transformable represents the foundational layer of data processing within the FireHub ecosystem, serving as the basis
 * for higher-level operations such as filtering, partitioning, and pipeline composition.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
interface Transformable {

    /**
     * ### Map Values Transformation
     *
     * Transforms each element of the data structure by applying the given callback and returns a new instance
     * containing the transformed values. The original structure remains unchanged.<br>
     * This operation preserves the structural shape (e.g., order and keys, where applicable) while modifying only the
     * values. It represents a fundamental, immutable transformation used as the basis for higher-level data processing
     * operations.
     * @since 1.0.0
     *
     * @template TReturnValue
     *
     * @param callable(TValue, TKey):TReturnValue $callback <p>
     * A callback function that takes the value and key of each element and returns a transformed value.
     * </p>
     *
     * @return static<TKey, TReturnValue> A new instance of the same type containing the mapped values.
     */
    public function map (callable $callback):static;

}