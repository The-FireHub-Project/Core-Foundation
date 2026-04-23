<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @package Core\Test
 */

namespace FireHub\Tests\Unit\Shared\Enums\Number;

use FireHub\Core\Testing\Base;
use FireHub\Core\Shared\Enums\Number\Round;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProvider, Group, Small
};
use RoundingMode;

/**
 * ### Test Rounding modes
 * @since 1.0.0
 */
#[Small]
#[Group('shared')]
#[Group('enums')]
#[CoversClass(Round::class)]
final class RoundTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param \FireHub\Core\Shared\Enums\Number\Round $mode
     * @param RoundingMode $expected
     *
     * @return void
     */
    #[DataProvider('provideRoundingModes')]
    public function testCalculate (Round $mode, RoundingMode $expected):void {

        self::assertSame($expected, $mode->calculate());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testAllEnumCasesAreMapped():void {

        foreach (Round::cases() as $case)
            self::assertInstanceOf(RoundingMode::class, $case->calculate());

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<\FireHub\Core\Shared\Enums\Number\Round, RoundingMode>>
     */
    public static function provideRoundingModes():array {

        return [
            [Round::HALF_AWAY_FROM_ZERO, RoundingMode::HalfAwayFromZero],
            [Round::HALF_TOWARDS_ZERO, RoundingMode::HalfTowardsZero],
            [Round::HALF_EVEN, RoundingMode::HalfEven],
            [Round::HALF_ODD, RoundingMode::HalfOdd],
            [Round::TOWARDS_ZERO, RoundingMode::TowardsZero],
            [Round::AWAY_FROM_ZERO, RoundingMode::AwayFromZero],
            [Round::NEGATIVE_INFINITY, RoundingMode::NegativeInfinity],
            [Round::POSITIVE_INFINITY, RoundingMode::PositiveInfinity],
        ];

    }

}