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
 * ### Linear Boundary Access Capability
 *
 * Defines the ability for a storage implementation to provide direct access to the boundaries
 * of a linear sequence. This includes retrieving the first element and the last element without requiring full
 * traversal of the underlying data. Intended as an optional optimization layer for linear structures where boundary
 * access can be performed in constant time, while maintaining separation between storage concerns and data structure
 * semantics.
 * @since 1.0.0
 *
 * @template TValue
 */
interface LinearBoundaryAccess {

    /**
     * ### Retrieve the first element
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Type\Maybe As return.
     *
     * @return \FireHub\Core\Shared\Type\Maybe<null>|\FireHub\Core\Shared\Type\Maybe<TValue> Maybe with first element
     * of the storage, or Maybe with null if storage is empty.
     */
    public function first ():Maybe;

    /**
     * ### Retrieve the last element
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Type\Maybe As return.
     *
     * @return \FireHub\Core\Shared\Type\Maybe<null>|\FireHub\Core\Shared\Type\Maybe<TValue> Maybe with last element
     * of the storage, or Maybe with null if storage is empty.
     */
    public function last ():Maybe;

}