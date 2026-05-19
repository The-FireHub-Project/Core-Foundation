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
 * ### Back Removal
 *
 * Provides the ability to remove one or more elements from the logical end of the structure in constant time.
 * @since 1.0.0
 */
interface BackRemoval {

    /**
     * ### Removes values from the back
     * @since 1.0.0
     *
     * @param int $items [optional] <p>
     * Number of values to remove from the back of the storage.
     * </p>
     *
     * @return static The modified storage structure.
     */
    public function removeLast (int $items = 1):static;

}