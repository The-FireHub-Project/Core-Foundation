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

/**
 * ### Back Insertion
 *
 * Provides the ability to insert one or more elements at the logical end of the structure in constant time, assuming
 * tail access is available.
 * @since 1.0.0
 *
 * @template TValue
 */
interface BackInsertion {

    /**
     * ### Prepend values to the back
     * @since 1.0.0
     *
     * @param TValue ...$values <p>
     * List of values to add to the back of the storage.
     * </p>
     *
     * @return static The modified storage structure.
     */
    public function addLast (mixed ...$values):static;

}