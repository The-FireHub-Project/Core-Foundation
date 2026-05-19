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
use FireHub\Core\Throwable\Exception\Support\DataStructure\OutOfBoundsException;
use FireHub\Core\Throwable\Error\LowLevel\Arr\OutOfRangeError;
use FireHub\Core\Support\LowLevel\Arr;

/**
 * ### Generate a sequential array from a numeric or string range
 *
 * Creates a contiguous sequence of values between a defined start and end boundary, optionally using a custom step.
 * Useful for quickly bootstrapping collections with predictable numeric keys or values (e.g., index ranges, pagination
 * offsets, test datasets). The initializer ensures consistent ordering and supports both ascending and descending
 * ranges, depending on the provided step.
 * @since 1.0.0
 *
 * @template TValue of float|int|string
 *
 * @implements \FireHub\Core\Support\DataStructure\Storage\Initialization\ArrStorageInitializer<int, TValue>
 */
final readonly class ArrRangeInitializer implements ArrStorageInitializer {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param TValue $start <p>
     * The starting value of the range.
     * </p>
     * @param TValue $end <p>
     * The ending value of the range.
     * </p>
     * @param (TValue is float ? float : int|float) $step [optional] <p>
     * The step size between each value in the range. Defaults to 1.
     * </p>
     *
     * @return void
     */
    public function __construct(
        private int|float|string $start,
        private int|float|string $end,
        private int|float $step = 1
    ) {}

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Arr::range() To create an array containing a range of elements.
     *
     * @throws \FireHub\Core\Shared\Contracts\Throwable
     * @throws \FireHub\Core\Throwable\Exception\Support\DataStructure\OutOfBoundsException If $step is 0, $start, $end,
     * or $step is not finite, or $step is negative, but the produced range is increasing (in other words, $start <=
     * $end), or if one is string, but not both.
     *
     * @note Character sequence values are limited to a length of one.<br>
     * If a length greater than one is entered only the first character is used.
     */
    public function __invoke ():array {

        try {

            /** @var array<int, TValue> */
            return Arr::range($this->start, $this->end, $this->step);

        } catch (OutOfRangeError $error) {

            throw OutOfBoundsException::builder()
                ->withMessage($error->getMessage())
                ->withContext([
                    'start' => $this->start,
                    'end' => $this->end,
                    'step' => $this->step
                ])
                ->build();

        }

    }

}