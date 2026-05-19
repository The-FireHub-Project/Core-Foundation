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
use FireHub\Core\Support\LowLevel\Arr;

/**
 * ### Initialize an array by filling it with a repeated value
 *
 * Creates an array of a defined size where each element is initialized with the same value. Useful for pre-allocating
 * collections, setting default states, or bootstrapping predictable datasets (e.g., fixed-size buffers, placeholders,
 * or test fixtures). The initializer ensures consistent indexing and value assignment across the entire range,
 * providing a fast and deterministic way to populate storage.
 * @since 1.0.0
 *
 * @template TValue
 *
 * @implements \FireHub\Core\Support\DataStructure\Storage\Initialization\ArrStorageInitializer<int, TValue>
 */
final readonly class ArrFillInitializer implements ArrStorageInitializer {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param TValue $value <p>
     * Value to use for filling.
     * </p>
     * @param int $start_index <p>
     * The first index of the returned array.
     * </p>
     * @param int<0, 2147483647> $length <p>
     * Number of elements to insert. Must be greater than or equal to zero.
     * </p>
     *
     * @return void
     */
    public function __construct(
        private mixed $value,
        private int $start_index,
        private int $length
    ) {}

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::fill() To fill an array with values.
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\OutOfRangeError If $length is out of range.
     */
    public function __invoke ():array {

        return Arr::fill($this->value, $this->start_index, $this->length);

    }

}