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

namespace FireHub\Core\Support\Contracts;

use FireHub\Core\Shared\Contracts\ {
    Countable, IteratorAggregate
};

use const FireHub\Core\Shared\Constants\Number\MAX;

/**
 * ### Data structures Contract
 *
 * Defines a generic, type-safe contract for all high-level data structures in FireHub.<br>
 * Supports iteration, array conversion, serialization, and common utility operations, ensuring consistency across
 * collections, lazy collections, and other linear or dynamic data containers.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @extends \FireHub\Core\Shared\Contracts\IteratorAggregate<TKey, TValue>
 */
interface DataStructure extends Countable, IteratorAggregate {

    /**
     * ### Call a user-generated function on each item in the data structure
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Constants\Number\MAX As default limit.
     * @uses \FireHub\Core\Shared\Enums\ControlFlow\Signal::BREAK As signal.
     *
     * @param callable(TValue, TKey):(\FireHub\Core\Shared\Enums\ControlFlow\Signal::BREAK|\FireHub\Core\Shared\Enums\ControlFlow\Signal::CONTINUE) $callback <p>
     * Function to call on each item in a data structure.<br>
     * Return `Signal::BREAK` to stop iteration early.
     * Return `Signal::CONTINUE` to continue iteration.
     * </p>
     * @param positive-int $limit [optional] <p>
     * Maximum number of elements that is allowed to be iterated.
     * </p>
     *
     * @return static This data structure.
     */
    public function each (callable $callback, int $limit = MAX):static;

}