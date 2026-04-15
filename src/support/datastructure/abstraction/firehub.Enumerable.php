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

namespace FireHub\Core\Support\DataStructure\Abstraction;

use FireHub\Core\Support\Contracts\DataStructure;
use FireHub\Core\Shared\Contracts\IteratorAggregate;

/**
 * ### Enumerable Contract
 *
 * Defines the ability to iterate over all elements in a structure. Provides higher-level traversal operations such
 * as mapping, filtering, and transformation, typically built on top of a traversal mechanism.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @extends \FireHub\Core\Support\Contracts\DataStructure<TKey, TValue>
 * @extends \FireHub\Core\Shared\Contracts\IteratorAggregate<TKey, TValue>
 */
interface Enumerable extends DataStructure, IteratorAggregate {

    /**
     * ### Tap into the enumerable for side effects
     * @since 1.0.0
     *
     * @param callable(TValue, TKey):void $callback <p>
     * Function to call on each item in a data structure.
     * </p>
     *
     * @return $this
     */
    public function tap (callable $callback):static;

    /**
     * ### Call a user-generated function on each item in the data structure
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\ControlFlow\Signal::BREAK As signal.
     * @uses \FireHub\Core\Shared\Enums\ControlFlow\Signal::CONTINUE As signal.
     *
     * @param callable(TValue, TKey):(\FireHub\Core\Shared\Enums\ControlFlow\Signal::BREAK|\FireHub\Core\Shared\Enums\ControlFlow\Signal::CONTINUE) $callback <p>
     * Function to call on each item in a data structure.<br>
     * Return `Signal::BREAK` to stop iteration early.<br>
     * Return `Signal::CONTINUE` to continue iteration.
     * </p>
     *
     * @return void
     */
    public function each (callable $callback):void;

}