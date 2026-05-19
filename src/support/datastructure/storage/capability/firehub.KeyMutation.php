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
 * ### Associative Key Mutation Capability
 *
 * A storage capability that enables modification of elements based on associative keys (string or integer
 * identifiers). It defines write and removal operations over key-value storage models such as maps, dictionaries,
 * and registries. The abstraction assumes a key-based addressing scheme where keys represent stable identifiers
 * rather than positional indexes.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 */
interface KeyMutation {

    /**
     * ### Set Value by Key
     *
     * AAssigns a value to the specified key in the associative storage. If the key already exists, the existing
     * value is overwritten. If it does not exist, a new entry is created. This operation is fundamental for
     * key-value-based structures and does not involve positional logic or traversal.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\MutationOutcome As return.
     *
     * @param TKey $key <p>
     * The key where the value will be added.
     * </p>
     * @param TValue $value <p>
     * Value to add to the key.
     * </p>
     *
     * @return \FireHub\Core\Shared\Enums\MutationOutcome::CREATED|\FireHub\Core\Shared\Enums\MutationOutcome::UPDATED
     * An enum indicating the result of the mutation operation.
     */
    public function set (int|string $key, mixed $value):MutationOutcome;

    /**
     * ### Remove Value by Key
     *
     * Removes the entry associated with the specified key from the storage. If the key does not exist, the operation
     * has no effect. This mutation affects only the associative mapping layer and does not depend on element ordering
     * or structural position.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\MutationOutcome As return.
     *
     * @param TKey $key <p>
     * The key of the value to remove.
     * </p>
     *
     * @return \FireHub\Core\Shared\Enums\MutationOutcome::REMOVED|\FireHub\Core\Shared\Enums\MutationOutcome::NOT_FOUND
     * An enum indicating the result of the mutation operation.
     */
    public function remove (int|string $key):MutationOutcome;

}