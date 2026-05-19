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
 */

namespace FireHub\Core\Support\DataStructure\Storage\Capability;

use FireHub\Core\Shared\Enums\MutationOutcome;

/**
 * ### Positional Index Mutation Capability
 *
 * A storage capability that enables modification of elements based on their positional index within a linear
 * structure. It defines write and removal operations over indexed storage models such as arrays, lists, fixed
 * buffers, and ring buffers. The abstraction assumes a positional addressing scheme where integer indexes represent
 * logical positions rather than identity or key-based mappings.
 * @since 1.0.0
 *
 * @template TValue
 */
interface IndexMutation {

    /**
     * ### Set Value at Index
     *
     * Assigns a value to the specified positional index in the storage. If the index already contains a value, it is
     * overwritten according to the storage’s mutation semantics. This operation assumes a valid index-based
     * addressing model and does not perform key resolution or structural lookup.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\MutationOutcome As return.
     *
     * @param int $index <p>
     * The key where the value will be added.
     * </p>
     * @param TValue $value <p>
     * Value to add to the index.
     * </p>
     *
     * @return \FireHub\Core\Shared\Enums\MutationOutcome::CREATED|\FireHub\Core\Shared\Enums\MutationOutcome::UPDATED
     * An enum indicating the result of the mutation operation.
     */
    public function set (int $index, mixed $value):MutationOutcome;

    /**
     * ### Remove Value by Index
     *
     * Removes the element located at the specified index. The behavior after removal depends on the storage
     * implementation (e.g., shifting in lists, pulling in fixed storage, or logical repositioning in ring buffers).
     * This operation affects structural layout but not value semantics directly.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\MutationOutcome As return.
     *
     * @param int $index <p>
     * The key of the value to remove.
     * </p>
     *
     * @return \FireHub\Core\Shared\Enums\MutationOutcome::REMOVED|\FireHub\Core\Shared\Enums\MutationOutcome::NOT_FOUND
     * An enum indicating the result of the mutation operation.
     */
    public function remove (int $index):MutationOutcome;

}