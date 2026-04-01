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
     * $collection = new Collection(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $collection->count();
     *
     * // 6
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
     * use FireHub\Core\Support\DataStructures\Collection;
     *
     * $collection = new Collection(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $collection->each(
     *    function ($value, $key):Signal {
     *    echo $value.',';
     *    return Signal::CONTINUE;
     * });
     *
     * // 'John,Jane,Jane,Jane,Richard,Richard,'
     * </code>
     *
     * You can limit the number of elements:
     * <code>
     * use FireHub\Core\Support\DataStructures\Collection;
     *
     * $collection = new Collection(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $collection->each(
     *    function ($value, $key):Signal {
     *    echo $value.',';
     *    return Signal::CONTINUE;
     * }, limit: 2);
     *
     * $collection->each(fn($value, $key) => print($value.','), limit: 2);
     *
     * // 'John,Jane,'
     * </code>
     *
     * You can also stop at any time with returning Signal::BREAK:
     * <code>
     * use FireHub\Core\Support\DataStructures\Collection;
     * use FireHub\Core\Shared\Enums\ControlFlow\Signal;
     *
     * $collection = new Collection(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $collection->each(
     *    function ($value, $key):Signal {
     *    if ($value === 'Richard') return Signal::BREAK;
     *    echo $value.',';
     *    return Signal::CONTINUE;
     * });
     *
     * // 'John,Jane,Jane,Jane,'
     * </code>
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