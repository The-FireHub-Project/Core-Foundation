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

use FireHub\Core\Support\DataStructure\Storage\Initialization\ArrStorageInitializer;
use Closure;

/**
 * ### Initialize an array using a value-generating callback
 *
 * A concrete ArrStorageInitializer implementation that delegates array creation to a user-provided callback.
 * Executes the callback during initialization to produce the underlying dataset, enabling flexible, dynamic, or
 * computed data generation while preserving a consistent initialization contract.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \FireHub\Core\Support\DataStructure\Storage\Initialization\ArrStorageInitializer<TKey, TValue>
 */
final readonly class ArrCallbackInitializer implements ArrStorageInitializer {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param Closure():array<TKey, TValue> $callback <p>
     * A callback function that returns an array of key-value pairs to be used as the underlying dataset.
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
    public function __invoke ():array {

        return ($this->callback)();

    }

}