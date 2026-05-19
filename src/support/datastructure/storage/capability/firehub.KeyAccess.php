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
 */

namespace FireHub\Core\Support\DataStructure\Storage\Capability;

use FireHub\Core\Shared\Type\Maybe;

/**
 * ### Key-Based Read Access Capability
 *
 * A storage capability that provides read-only access to elements identified by a key (string or integer). It
 * enables safe retrieval and existence checks without exposing mutation operations or internal storage structure.
 * Designed for associative data structures such as maps, registries, and indexed key-value stores where lookup
 * semantics are primary and structural details remain encapsulated.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 */
interface KeyAccess {

    /**
     * ### Check Key Existence
     *
     * Determines whether a value exists for the specified key in the storage. Provides a fast existence check
     * without retrieving the underlying value, enabling safe conditional access patterns.
     * @since 1.0.0
     *
     * @param TKey $key <p>
     * The key to check for existence.
     * </p>
     *
     * @return bool True if the key exists, false otherwise.
     */
    public function has (int|string $key):bool;

    /**
     * ### Retrieve Value by Key
     *
     * Retrieves the value associated with the given key from an associative storage structure. If the key does not
     * exist, an empty Maybe is returned instead of null, ensuring explicit handling of missing entries. This operation
     * does not modify the storage and is designed for safe, read-only access to key-based data mappings such as
     * dictionaries, maps, and registries.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Type\Maybe As return.
     *
     * @param TKey $key <p>
     * The key to retrieve value by key.
     * </p>
     *
     * @return \FireHub\Core\Shared\Type\Maybe<null>|\FireHub\Core\Shared\Type\Maybe<TValue> Maybe with element at key
     * position of the storage, or Maybe with null if element at key position of the storage doesn't exist.
     */
    public function get (int|string $key):Maybe;

}