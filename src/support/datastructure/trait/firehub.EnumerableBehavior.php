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

namespace FireHub\Core\Support\DataStructure\Trait;

use FireHub\Core\Shared\Enums\ControlFlow\Signal;
use FireHub\Core\Throwable\Exception\DataStructure\WrongReturnTypeException;

/**
 * ### Enumerable Behavior Trait
 *
 * Reusable iteration behavior for data structures, providing common functional operations over any IteratorAggregate
 * implementation with a consistent traversal model.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
trait EnumerableBehavior {

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructure\DS;
     *
     * $ds = DS::sequence()->fromArray(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $called = [];
     * $ds->each(
     *    function ($value, $key) use (&$called):void {
     *    $called[] = $value;
     * });
     *
     * print $called;
     *
     * // ['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']
     * </code>
     *
     * @since 1.0.0
     */
    public function tap (callable $callback):static {

        foreach ($this as $key => $value)
            $callback($value, $key);

        return $this;

    }

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructure\DS;
     * use FireHub\Core\Shared\Enums\ControlFlow\Signal;
     *
     * $ds = DS::sequence()->fromArray(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $called = [];
     * $ds->each(
     *    function ($value, $key) use (&$called):Signal {
     *    $called[] = $value;
     *    return Signal::CONTINUE;
     * });
     *
     * print $called;
     *
     * // ['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']
     * </code>
     *
     * You can also stop at any time with returning Signal::BREAK:
     * <code>
     * use FireHub\Core\Support\DataStructure\DS;
     * use FireHub\Core\Shared\Enums\ControlFlow\Signal;
     *
     * $ds = DS::sequence()->fromArray(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $called = [];
     * $ds->each(
     *    function ($value, $key) use (&$called):Signal {
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
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Shared\Contracts\Throwable
     * @throws \FireHub\Core\Throwable\Exception\DataStructure\WrongReturnTypeException If the callback returns an
     * invalid signal.
     */
    public function each (callable $callback):void {

        foreach ($this as $key => $value) {

            $signal = $callback($value, $key);

            if ($signal === Signal::BREAK) break;
            if ($signal === Signal::CONTINUE) continue;
            throw WrongReturnTypeException::builder()
                ->withContext([
                    'type' => $signal
                ])
                ->build();

        }

    }

}