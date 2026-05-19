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

use FireHub\Core\Shared\Type\Maybe;

/**
 * ### Positional Index Access Capability
 *
 * A storage capability that provides read-only access to elements based on their positional index within a linear
 * structure. It enables safe retrieval and existence checks over ordered collections such as arrays, lists, fixed-size
 * buffers, and ring buffers. The abstraction assumes a dense or logically mapped index space where each integer index
 * represents a position rather than an identity or key.
 * @since 1.0.0
 *
 * @template TValue
 */
interface IndexAccess {

    /**
     * ### Check Index Existence
     *
     * Determines whether a valid element exists at the given positional index. This operation does not retrieve the
     * value and is optimized for fast boundary or presence checks within indexed storage structures.
     * @since 1.0.0
     *
     * @param int $index <p>
     * The key to check for existence.
     * </p>
     *
     * @return bool True if the key exists, false otherwise.
     */
    public function has (int $index):bool;

    /**
     * ### Retrieve Value by Index
     *
     * Returns the value located at the specified positional index within the storage. If the index does not exist or
     * is out of bounds, an empty Maybe is returned. This operation provides safe, read-only access to ordered storage
     * without exposing internal structure or requiring direct array access.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Type\Maybe As return.
     *
     * @param int $index <p>
     * The key to retrieve value by index.
     * </p>
     *
     * @return \FireHub\Core\Shared\Type\Maybe<null>|\FireHub\Core\Shared\Type\Maybe<TValue> Maybe with element at index
     * position of the storage, or Maybe with null if element at index position of the storage doesn't exist.
     */
    public function get (int $index):Maybe;

}