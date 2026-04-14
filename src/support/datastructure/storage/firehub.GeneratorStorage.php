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
class GeneratorStorage implements Storage {

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
     * @uses \FireHub\Core\Support\DataStructure\Storage\GeneratorStorage::create() To produce the generator for
     * entries.
     */
    public function entries ():iterable {

        return $this->create();

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\GeneratorStorage::create() To produce the generator for
     * values.
     */
    public function keys ():iterable {

        foreach ($this->create() as $key => $value)
            yield $key;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\GeneratorStorage::create() To produce the generator for
     * keys.
     */
    public function values ():iterable {

        foreach ($this->create() as $value)
            yield $value;

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

}