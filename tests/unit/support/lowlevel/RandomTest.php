<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @package Core\Test
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Tests\Unit\Support\LowLevel;

use FireHub\Core\Testing\Base;
use FireHub\Core\Throwable\Error\LowLevel\Random\ {
    MaxLessThanMinError, NumberGreaterThanMaxError, NumberLessThanMinError
};
use FireHub\Core\Support\LowLevel\Random;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Random Number and Data Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[Group('lowlevel')]
#[CoversClass(Random::class)]
final class RandomTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $min
     * @param null|non-negative-int $max
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\NumberLessThanMinError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\MaxLessThanMinError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\NumberGreaterThanMaxError
     *
     * @return void
     */
    #[TestWith([0, 100])]
    public function testNumber (int $min = 0, ?int $max = null):void {

        $actual = Random::number($min, $max);

        self::assertIsInt($actual);
        self::assertGreaterThanOrEqual($min, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param int $min
     * @param null|int $max
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\MaxLessThanMinError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\NumberGreaterThanMaxError
     *
     * @return void
     */
    #[TestWith([-1])]
    public function testNumberLessThenMin (int $min = 0, ?int $max = null):void {

        $this->expectException(NumberLessThanMinError::class);

        Random::number($min, $max);

    }

    /**
     * @since 1.0.0
     *
     * @param int $min
     * @param null|int $max
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\NumberLessThanMinError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\NumberGreaterThanMaxError
     *
     * @return void
     */
    #[TestWith([10, 5])]
    public function testNumberMaxLessThenMin (int $min = 0, ?int $max = null):void {

        $this->expectException(MaxLessThanMinError::class);

        Random::number($min, $max);

    }

    /**
     * @since 1.0.0
     *
     * @param int $min
     * @param null|int $max
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\NumberLessThanMinError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\MaxLessThanMinError
     *
     * @return void
     */
    #[TestWith([0, PHP_INT_MAX])]
    public function testNumberGreaterThenMax (int $min = 0, ?int $max = null):void {

        $this->expectException(NumberGreaterThanMaxError::class);

        Random::number($min, $max);

    }
    /**
     * @since 1.0.0
     *
     * @param int $min
     * @param int $max
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\MaxLessThanMinError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\SecureNumberError
     *
     * @return void
     */
    #[TestWith([0, 100])]
    public function testSecureNumber (int $min, int $max):void {

        $actual = Random::secureNumber($min, $max);

        self::assertIsInt($actual);
        self::assertGreaterThanOrEqual($min, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param int $min
     * @param int $max
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\SecureNumberError
     *
     * @return void
     */
    #[TestWith([10, 5])]
    public function testSecureNumberMaxLessThenMin (int $min, int $max):void {

        $this->expectException(MaxLessThanMinError::class);

        Random::secureNumber($min, $max);

    }

    /**
     * @since 1.0.0
     *
     * @param int $length
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\MaxLessThanMinError If the length is less than 1.
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\SecureNumberError
     *
     * @return void
     */
    #[TestWith([20])]
    public function testBytes (int $length):void {

        $actual = Random::bytes($length);

        self::assertIsString($actual);

    }

    /**
     * @since 1.0.0
     *
     * @param int $length
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Random\SecureNumberError
     *
     * @return void
     */
    #[TestWith([0])]
    public function testBytesLengthLessThenMin (int $length):void {

        $this->expectException(MaxLessThanMinError::class);

        Random::bytes($length);

    }

}