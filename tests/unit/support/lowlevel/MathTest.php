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
use FireHub\Core\Shared\Enums\Number\ {
    Round, LogBase
};
use FireHub\Core\Throwable\Error\LowLevel\Number\ {
    ArithmeticError, DivideByZeroError
};
use FireHub\Core\Support\LowLevel\Math;
use FireHub\Tests\DataProviders\NumDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Depends, Small, TestWith
};

/**
 * ### Test Math low-level proxy class
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[Group('lowlevel')]
#[CoversClass(Math::class)]
final class MathTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param bool $excepted
     * @param float $number
     *
     * @return void
     */
    #[TestWith([true, 10])]
    #[TestWith([false, NAN])]
    #[TestWith([false, INF])]
    public function testIsFinite (bool $excepted, float $number):void {

        self::assertSame($excepted, Math::isFinite($number));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $excepted
     * @param float $number
     *
     * @return void
     */
    #[TestWith([true, INF])]
    #[TestWith([false, 10.5])]
    public function testIsInfinite (bool $excepted, float $number):void {

        self::assertSame($excepted, Math::isInfinite($number));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $excepted
     * @param float $number
     *
     * @return void
     */
    #[TestWith([true, NAN])]
    #[TestWith([false, 10.5])]
    #[TestWith([false, INF])]
    public function testIsNan (bool $excepted, float $number):void {

        self::assertSame($excepted, Math::isNan($number));

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param int $dividend
     * @param non-zero-int $divisor
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Number\ArithmeticError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Number\DivideByZeroError
     *
     * @return void
     */
    #[TestWith([1, 3, 2])]
    #[TestWith([-1, -3, 2])]
    #[TestWith([-1, 3, -2])]
    #[TestWith([1, -3, -2])]
    #[TestWith([0, PHP_INT_MAX, PHP_INT_MIN])]
    #[TestWith([-1, PHP_INT_MIN, PHP_INT_MAX])]
    public function testDivide (int $expected, int $dividend, int $divisor):void {

        self::assertSame($expected, Math::divideIntegers($dividend, $divisor));

    }

    /**
     * @since 1.0.0
     *
     * @param int $dividend
     * @param non-zero-int $divisor
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Number\ArithmeticError
     *
     * @return void
     */
    #[TestWith([PHP_INT_MIN, -1])]
    public function testDivideError (int $dividend, int $divisor):void {

        $this->expectException(ArithmeticError::class);

        Math::divideIntegers($dividend, $divisor);

    }

    /**
     * @since 1.0.0
     *
     * @param int $dividend
     * @param non-zero-int $divisor
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Number\DivideByZeroError
     *
     * @return void
     */
    #[TestWith([1, 0])]
    public function testDivideByZero (int $dividend, int $divisor):void {

        $this->expectException(DivideByZeroError::class);

        Math::divideIntegers($dividend, $divisor);

    }

    /**
     * @since 1.0.0
     *
     * @param float $result
     * @param float $dividend
     * @param float $divisor
     *
     * @return void
     */
    #[TestWith([2.0, 4, 2])]
    #[TestWith([INF, 1.0, 0.0])]
    #[TestWith([-INF, -1.0, 0.0])]
    #[TestWith([4.384615384615385, 5.7, 1.3])]
    #[Depends('testRound')]
    public function testDivideFloats (float $result, float $dividend, float $divisor):void {

        self::assertSame(Math::round($result, 5), Math::round(Math::divideFloats($dividend, $divisor), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $dividend
     * @param float $divisor
     *
     * @return void
     */
    #[TestWith([0.5, 5.7, 1.3])]
    public function testRemainder (float $expected, float $dividend, float $divisor):void {

        self::assertSame($expected, Math::remainder($dividend, $divisor));

    }

    /**
     * @since 1.0.0
     *
     * @param float|int $float
     *
     * @return void
     */
    #[DataProviderExternal(NumDataProvider::class, 'positiveInt')]
    #[DataProviderExternal(NumDataProvider::class, 'negativeInt')]
    #[DataProviderExternal(NumDataProvider::class, 'positiveFloat')]
    #[DataProviderExternal(NumDataProvider::class, 'negativeFloat')]
    #[DataProviderExternal(NumDataProvider::class, 'null')]
    public function testAbsolute (float|int $float):void {

        self::assertTrue(Math::absolute($float) >= 0);

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param float|int $number
     *
     * @return void
     */
    #[TestWith([5, 4.3])]
    #[TestWith([10, 9.999])]
    #[TestWith([-3, -3.14])]
    public function testCeil (int $expected, float|int $number):void {

        self::assertSame($expected, Math::ceil($number));

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param float|int $number
     *
     * @return void
     */
    #[TestWith([4, 4.3])]
    #[TestWith([9, 9.999])]
    #[TestWith([-4, -3.14])]
    public function testFloor (int $expected, float|int $number):void {

        self::assertSame($expected, Math::floor($number));

    }

    /**
     * @since 1.0.0
     *
     * @param int|float $expected
     * @param int|float $number
     * @param int $precision
     * @param \FireHub\Core\Shared\Enums\Number\Round $round
     *
     * @return void
     */
    #[TestWith([2, 1.5, 0, Round::HALF_AWAY_FROM_ZERO])]
    #[TestWith([1, 0.5, 0, Round::HALF_AWAY_FROM_ZERO])]
    #[TestWith([0, 0.49, 0, Round::HALF_AWAY_FROM_ZERO])]
    #[TestWith([-0.4, -0.35, 1, Round::HALF_AWAY_FROM_ZERO])]
    #[TestWith([0.46, 0.455, 2, Round::HALF_AWAY_FROM_ZERO])]
    #[TestWith([1, 1.5, 0, Round::HALF_TOWARDS_ZERO])]
    #[TestWith([0, 0.5, 0, Round::HALF_TOWARDS_ZERO])]
    #[TestWith([0, 0.49, 0, Round::HALF_TOWARDS_ZERO])]
    #[TestWith([-0.3, -0.35, 1, Round::HALF_TOWARDS_ZERO])]
    #[TestWith([0.45, 0.455, 2, Round::HALF_TOWARDS_ZERO])]
    #[TestWith([1, 1.5, 0, Round::HALF_ODD])]
    #[TestWith([1, 0.5, 0, Round::HALF_ODD])]
    #[TestWith([0, 0.49, 0, Round::HALF_ODD])]
    #[TestWith([-0.3, -0.35, 1, Round::HALF_ODD])]
    #[TestWith([0.45, 0.455, 2, Round::HALF_ODD])]
    #[TestWith([2, 1.5, 0, Round::HALF_EVEN])]
    #[TestWith([0, 0.5, 0, Round::HALF_EVEN])]
    #[TestWith([0, 0.49, 0, Round::HALF_EVEN])]
    #[TestWith([-0.4, -0.35, 1, Round::HALF_EVEN])]
    #[TestWith([0.46, 0.455, 2, Round::HALF_EVEN])]
    #[TestWith([1, 1.5, 0, Round::TOWARDS_ZERO])]
    #[TestWith([0, 0.5, 0, Round::TOWARDS_ZERO])]
    #[TestWith([0, 0.49, 0, Round::TOWARDS_ZERO])]
    #[TestWith([-0.3, -0.35, 1, Round::TOWARDS_ZERO])]
    #[TestWith([0.45, 0.455, 2, Round::TOWARDS_ZERO])]
    #[TestWith([2, 1.5, 0, Round::AWAY_FROM_ZERO])]
    #[TestWith([1, 0.5, 0, Round::AWAY_FROM_ZERO])]
    #[TestWith([1, 0.49, 0, Round::AWAY_FROM_ZERO])]
    #[TestWith([-0.4, -0.35, 1, Round::AWAY_FROM_ZERO])]
    #[TestWith([0.46, 0.455, 2, Round::AWAY_FROM_ZERO])]
    #[TestWith([1, 1.5, 0, Round::NEGATIVE_INFINITY])]
    #[TestWith([0, 0.5, 0, Round::NEGATIVE_INFINITY])]
    #[TestWith([0, 0.49, 0, Round::NEGATIVE_INFINITY])]
    #[TestWith([-0.4, -0.35, 1, Round::NEGATIVE_INFINITY])]
    #[TestWith([0.45, 0.455, 2, Round::NEGATIVE_INFINITY])]
    public function testRound (int|float $expected, float|int $number, int $precision = 0, Round $round = Round::HALF_AWAY_FROM_ZERO):void {

        self::assertSame($expected, Math::round($number, $precision, $round));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float|int $number
     * @param float|\FireHub\Core\Shared\Enums\Number\LogBase $base
     *
     * @return void
     */
    #[TestWith([2.302585092994046, 10, LogBase::E])]
    #[TestWith([6.282411788757109, 10, LogBase::LOG2E])]
    #[TestWith([-2.7607859935346917, 10, LogBase::LOG10E])]
    #[TestWith([-6.282411788757108, 10, LogBase::LN2])]
    #[TestWith([2.7607859935346912, 10, LogBase::LN10])]
    #[TestWith([0.28893129185221283, 1.335, LogBase::E])]
    #[TestWith([0.788324982905575, 1.335, LogBase::LOG2E])]
    #[TestWith([-0.34642692079720505, 1.335, LogBase::LOG10E])]
    #[TestWith([-0.7883249829055747, 1.335, LogBase::LN2])]
    #[TestWith([0.346426920797205, 1.335, LogBase::LN10])]
    #[Depends('testRound')]
    public function testLog (float $expected, float|int $number, float|LogBase $base = LogBase::E):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::log($number, $base), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float|int $number
     *
     * @return void
     */
    #[TestWith([2.3978952727983707, 10])]
    #[TestWith([0.8480118911208606, 1.335])]
    #[Depends('testRound')]
    public function testLog1p (float $expected, float|int $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::log1p($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float|int $number
     *
     * @return void
     */
    #[TestWith([1.0, 10])]
    #[TestWith([0.125481265700594, 1.335])]
    #[Depends('testRound')]
    public function testLog10 (float $expected, float|int $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::log10($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $expected
     * @param array<array-key, mixed> $values
     *
     * @return void
     */
    #[TestWith([8, [2, 6, 8]])]
    #[TestWith([4.23544, [2.345, 4.23544, 4.1214]])]
    public function testMax (mixed $expected, array $values):void {

        self::assertSame($expected, Math::max(...$values));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $expected
     * @param array<array-key, mixed> $values
     *
     * @return void
     */
    #[TestWith([2, [2, 6, 8]])]
    #[TestWith([2.345, [2.345, 4.23544, 4.1214]])]
    public function testMin (mixed $expected, array $values):void {

        self::assertSame($expected, Math::min(...$values));

    }

    /**
     * @since 1.0.0
     *
     * @param float|int $expected
     * @param float|int $base
     * @param float|int $exponent
     *
     * @return void
     */
    #[TestWith([256, 2, 8])]
    #[TestWith([0.1, 10, -1])]
    public function testPower (float|int $expected, float|int $base, float|int $exponent):void {

        self::assertSame($expected, Math::power($base, $exponent));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param int|float $number
     * @param non-negative-int $decimals
     * @param string $decimal_separator
     * @param string $thousands_separator
     *
     * @return void
     */
    #[TestWith(['5,000', 5000, 0, '.', ','])]
    #[TestWith(['456', 456, 0, ',', '.'])]
    #[TestWith(['45656,560', 45656.56, 3, ',', ''])]
    public function testFormat (string $expected, int|float $number, int $decimals, string $decimal_separator = '.', string $thousands_separator = ','):void {

        self::assertSame($expected, Math::format($number, $decimals, $decimal_separator, $thousands_separator));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $number
     *
     * @return void
     */
    #[TestWith([0.4031710572106902, 23.1])]
    #[TestWith([0.7853981633974483, 45])]
    #[Depends('testRound')]
    public function testDegreesToRadian (float $expected, int|float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::degreesToRadian($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $number
     *
     * @return void
     */
    #[TestWith([23.099939426289396, 0.40317])]
    #[TestWith([45.0, 0.7853981633974483])]
    #[Depends('testRound')]
    public function testRadianToDegrees (float $expected, int|float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::radianToDegrees($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $number
     *
     * @return void
     */
    #[TestWith([298.8674009670603, 5.7])]
    #[TestWith([9744803446.2489, 23])]
    #[Depends('testRound')]
    public function testExponent (float $expected, int|float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::exponent($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $number
     *
     * @return void
     */
    #[TestWith([4839126178.743089, 22.3])]
    #[TestWith([9744803445.248903, 23])]
    #[Depends('testRound')]
    public function testExponent1 (float $expected, int|float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::exponent1($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $x
     * @param int|float $y
     *
     * @return void
     */
    #[TestWith([2.6832815729997477, 1.2, 2.4])]
    #[TestWith([2.23606797749979, 1, 2])]
    #[Depends('testRound')]
    public function testHypotenuseLength (float $expected, int|float $x, int|float $y):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::hypotenuseLength($x, $y), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param int|float $number
     *
     * @return void
     */
    #[TestWith([3.03315017762062, 9.2])]
    #[TestWith([3.0, 9])]
    #[Depends('testRound')]
    public function testSquareRoot (float $expected, int|float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::squareRoot($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([-1.0, M_PI])]
    public function testCosine (float $expected, float $number):void {

        self::assertSame($expected, Math::cosine($number));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([1.0471975511965979, 0.5])]
    #[Depends('testRound')]
    public function testCosineArc (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::cosineArc($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([1.1276259652063807, 0.5])]
    #[Depends('testRound')]
    public function testCosineHyperbolic (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::cosineHyperbolic($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.4435682543851153, 1.1])]
    #[Depends('testRound')]
    public function testCosineInverseHyperbolic (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::cosineInverseHyperbolic($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.479425538604203, 0.5])]
    #[Depends('testRound')]
    public function testSine (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::sine($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([1.5707963267948966, 1])]
    #[Depends('testRound')]
    public function testSineArc (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::sineArc($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([1.1752011936438014, 1])]
    #[Depends('testRound')]
    public function testSineHyperbolic (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::sineHyperbolic($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.881373587019543, 1])]
    #[Depends('testRound')]
    public function testSineHyperbolicInverse (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::sineHyperbolicInverse($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([1.5574077246549023, 1])]
    #[Depends('testRound')]
    public function testTangent (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::tangent($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.7853981633974483, 1])]
    #[Depends('testRound')]
    public function testTangentArc (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::tangentArc($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $x
     * @param float $y
     *
     * @return void
     */
    #[TestWith([0.7853981633974483, 1, 1])]
    public function testTangentArc2 (float $expected, float $x, float $y):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::tangentArc2($x, $y), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.7615941559557649, 1])]
    #[Depends('testRound')]
    public function testTangentHyperbolic (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::tangentHyperbolic($number), 5));

    }

    /**
     * @since 1.0.0
     *
     * @param float $expected
     * @param float $number
     *
     * @return void
     */
    #[TestWith([0.5493061443340549, 0.5])]
    #[Depends('testRound')]
    public function testTangentInverseHyperbolic (float $expected, float $number):void {

        self::assertSame(Math::round($expected, 5), Math::round(Math::tangentInverseHyperbolic($number), 5));

    }

}