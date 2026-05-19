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

namespace FireHub\Core\Support\DataStructure\Storage\Initialization;

use Generator;

/**
 * ### Generator Storage Initializer
 *
 * Defines a contract for initializing generator-based storage by producing an iterable data stream. Enables
 * deferred, memory-efficient data provisioning through generators while maintaining a consistent and encapsulated
 * initialization interface for streaming storage implementations.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
interface GeneratorStorageInitializer {

    /**
     * ### Invoke Initializer
     * @since 1.0.0
     *
     * @return Generator<TKey, TValue> Underlying data for storage.
     */
    public function __invoke ():Generator;

}