<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core\Shared
 */

namespace FireHub\Core\Shared\Contracts;

use Countable as InternalCountable;

/**
 * ### Countable contract
 *
 * Classes implementing Countable can be used with the count() function.
 * @since 1.0.0
 */
interface Countable extends InternalCountable {

    /**
     * ### Count elements of an object
     * @since 1.0.0
     *
     * @return non-negative-int Number of elements of an object.
     */
    public function count ():int;

}