<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.2
 * @package Core\Support
 */

namespace FireHub\Core\Support\DataStructure\Storage\Initialization\Strategy;

use FireHub\Core\Support\DataStructure\Storage\Initialization\GeneratorStorageInitializer;
use Closure, Generator;

/**
 * ### Generator Callback Initializer
 *
 * A concrete GeneratorStorageInitializer implementation that delegates data stream creation to a user-provided
 * callback. Executes the callback to return a generator or iterable sequence, allowing dynamic, lazy, and
 * memory-efficient data generation while preserving a uniform initialization contract.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @implements \FireHub\Core\Support\DataStructure\Storage\Initialization\GeneratorStorageInitializer<TKey, TValue>
 */
final readonly class GeneratorCallbackInitializer implements GeneratorStorageInitializer {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param Closure():Generator<TKey, TValue> $callback <p>
     * A callback function that returns an Generator of key-value pairs to be used as the underlying dataset.
     * </p>
     *
     * @return void
     */
    public function __construct(
        private Closure $callback
    ) {}

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function __invoke ():Generator {

        return ($this->callback)();

    }

}