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

namespace FireHub\Core\Support\DataStructure\Storage;

use FireHub\Core\Support\DataStructure\Storage;
use FireHub\Core\Support\DataStructure\Capability\Access\StreamingAccess;
use FireHub\Core\Support\LowLevel\Iterator;
use Closure, Generator;

/**
 * ### Generator-Based Storage
 *
 * Lazy, streaming-oriented storage implementation that produces elements on demand. Ideal for large or infinite
 * datasets where full materialization is not possible or desired.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @implements \FireHub\Core\Support\DataStructure\Storage<TKey, TValue>
 */
class GeneratorStorage implements Storage, StreamingAccess {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param Closure():Generator<TKey, TValue> $callable <p>
     * The callable that produces the generator.
     * </p>
     *
     * @return void
     */
    public function __construct (
        protected Closure $callable
    ) {}

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Iterator::count() To count the number of elements in the storage.
     */
    public function count ():int {

        return Iterator::count($this->create());

    }

    /**
     * ### Creates the generator
     * @since 1.0.0
     *
     * @return Generator<TKey, TValue> The generator produced by the callable.
     */
    private function create ():Generator {

        yield from ($this->callable)();

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\GeneratorStorage::create() To produce the generator for
     * entries.
     */
    public function entries ():iterable {

        return $this->create();

    }

}