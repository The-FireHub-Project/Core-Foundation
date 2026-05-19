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

namespace FireHub\Core\Support\DataStructure\Storage;

use FireHub\Core\Support\DataStructure\Storage;
use FireHub\Core\Support\DataStructure\Storage\Initialization\GeneratorStorageInitializer;

/**
 * ### Lazy Generator-Based Storage
 *
 * A read-optimized storage implementation based on PHP generators. Designed for streaming large or infinite datasets
 * where materialization is not required. Does not guarantee rewinding or persistent state beyond iteration, making
 * it suitable for pipeline-based or lazy evaluation scenarios.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 *
 * @implements \FireHub\Core\Support\DataStructure\Storage<TKey, TValue>
 */
final readonly class GeneratorStorage implements Storage {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\DataStructure\Storage\Initialization\GeneratorStorageInitializer As parameter.
     *
     * @param \FireHub\Core\Support\DataStructure\Storage\Initialization\GeneratorStorageInitializer<TKey, TValue> $initializer <p>
     * Initial data to store.
     * </p>
     *
     * @return void
     */
    public function __construct (
        private GeneratorStorageInitializer $initializer
    ) {}

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function iterate ():iterable {

        return ($this->initializer)();

    }

}