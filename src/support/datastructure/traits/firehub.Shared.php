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

namespace FireHub\Core\Support\DataStructure\Traits;

use FireHub\Core\Support\LowLevel\Iterator;
use FireHub\Core\Shared\Enums\ControlFlow\Signal;
use FireHub\Core\Throwable\Exception\DataStructure\WrongReturnTypeException;

use const FireHub\Core\Shared\Constants\Number\MAX;

/**
 * ### Shared Operations for All Data Structures
 *
 * A reusable trait providing common methods for all data structures, including element counting, emptiness checks,
 * key/value access, iteration, and conversion from other data structures. Designed to standardize shared behavior
 * across both linear and non-linear collections while minimizing code duplication.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
trait Shared {

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructures\Collection;
     *
     * $collection = new ArrayCollection(['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]);
     *
     * $collection->count();
     *
     * // 4
     * </code>
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Iterator::count() To count storage items.
     */
    public function count ():int {

        return Iterator::count($this);

    }

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructures\ArrayCollection;
     *
     * $collection = new ArrayCollection(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $called = [];
     * $collection->each(
     *    function ($value, $key):Signal {
     *    $called[] = $value;
     *    return Signal::CONTINUE;
     * });
     *
     * print $called;
     *
     * // ['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']
     * </code>
     *
     * You can limit the number of elements:
     * <code>
     * use FireHub\Core\Support\DataStructures\ArrayCollection;
     *
     * $collection = new ArrayCollection(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $called = [];
     * $collection->each(
     *    function ($value, $key):Signal {
     *    $called[] = $value;
     *    return Signal::CONTINUE;
     * }, limit: 2);
     *
     * print $called;
     *
     * // ['John', 'Jane']
     * </code>
     *
     * You can also stop at any time with returning Signal::BREAK:
     * <code>
     * use FireHub\Core\Support\DataStructures\ArrayCollection;
     * use FireHub\Core\Shared\Enums\ControlFlow\Signal;
     *
     * $collection = new ArrayCollection(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $called = [];
     * $collection->each(
     *    function ($value, $key):Signal {
     *    if ($value === 'Richard') return Signal::BREAK;
     *    echo $value.',';
     *    return Signal::CONTINUE;
     * });
     *
     * print $called;
     *
     * // ['John', 'Jane', 'Jane', 'Jane']
     * </code>
     *
     * @throws \FireHub\Core\Shared\Contracts\Throwable
     * @throws \FireHub\Core\Throwable\Exception\DataStructure\WrongReturnTypeException If the callback returns
     * an invalid signal.
     *
     * @since 1.0.0
     */
    public function each (callable $callback, int $limit = MAX):static {

        $counter = 0;

        foreach ($this as $key => $value) {

            if ($counter >= $limit) break;

            $signal = $callback($value, $key);

            $counter++;

            if ($signal === Signal::BREAK) break;
            if ($signal === Signal::CONTINUE) continue;
            throw WrongReturnTypeException::builder()
                ->withContext([
                    'type' => $signal
                ])
                ->build();

        }

        return $this;

    }

}