<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.4
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;
use FireHub\Core\Shared\Enums\Number\ {
    LogBase, Round
};

use function abs;
use function acos;
use function acosh;
use function asin;
use function asinh;
use function atan;
use function atan2;
use function atanh;
use function ceil;
use function cos;
use function cosh;
use function fdiv;
use function floor;
use function fmod;
use function deg2rad;
use function exp;
use function hypot;
use function intdiv;
use function is_finite;
use function is_infinite;
use function is_nan;
use function log;
use function log10;
use function log1p;
use function max;
use function min;
use function pow;
use function rad2deg;
use function round;
use function sin;
use function sinh;
use function sqrt;
use function tan;
use function tanh;

/**
 * ### Math low-level proxy class
 *
 * Math utilities act as thin proxies over native PHP numeric and mathematical functions.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class Math extends LowLevel {

    /**
     * ### Absolute value
     *
     * Returns the absolute value of $number.
     * @since 1.0.0
     *
     * @param float|int $number <p>
     * The numeric value to process.
     * </p>
     *
     * @return ($number is int ? int : float) The absolute value of number.
     */
    public static function absolute (float|int $number):float|int {

        return abs($number);

    }

    /**
     * ### Round fractions up
     *
     * Returns the next highest integer value by rounding up $number if necessary.
     * @since 1.0.0
     *
     * @param float|int $number <p>
     * The value to round up.
     * </p>
     *
     * @return int Rounded number up to the next highest integer.
     */
    public static function ceil (float|int $number):int {

        return (int)ceil($number);

    }

    /**
     * ### Round fractions down
     *
     * Returns the next lowest integer value (as float) by rounding down $number if necessary.
     * @since 1.0.0
     *
     * @param float|int $number <p>
     * The value to round down.
     * </p>
     *
     * @return int Rounded number up to the next lowest integer.
     */
    public static function floor (float|int $number):int {

        return (int)floor($number);

    }

    /**
     * ### Rounds a float
     *
     * Returns the rounded value of $number to specified $precision (number of digits after the decimal point).<br>
     * $precision can also be negative or zero (default).
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\Number\Round::HALF_AWAY_FROM_ZERO As default rounding mode.
     * @uses \FireHub\Core\Shared\Enums\Number\Round::calculate() To calculate rounding mode.
     *
     * @param float|int $number <p>
     * The value to round.
     * </p>
     * @param int $precision [optional] <p>
     * Number of decimal digits to round to.<br>
     * If the precision is positive, the num is rounded to precision significant digits after the decimal point.<br>
     * If the precision is negative, num is rounded to precision significant digits before the decimal point,
     * in other words, to the nearest multiple of pow(10, $precision).<br>
     * For example, for precision of -1 num is rounded to tens, for precision of -2 to hundreds, and so on.
     * </p>
     * @param \FireHub\Core\Shared\Enums\Number\Round $round [optional] <p>
     * Specify the mode in which rounding occurs.
     * </p>
     *
     * @return ($precision is positive-int ? float : int) Rounded number float.
     */
    public static function round (float|int $number, int $precision = 0, Round $round = Round::HALF_AWAY_FROM_ZERO):float|int {

        $result = round($number, $precision, $round->calculate());

        return $precision > 0 ? $result : (int)$result;

    }

    /**
     * ### Natural logarithm
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\Number\LogBase::E As default parameter.
     * @uses \FireHub\Core\Shared\Enums\Number\LogBase::value() To get log value.
     *
     * @param float|int $number <p>
     * The value to calculate the logarithm for.
     * </p>
     * @param \FireHub\Core\Shared\Enums\Number\LogBase|float $base [optional] <p>
     * The optional logarithmic base to use (defaults to 'e' and so to the natural logarithm).
     * </p>
     *
     * @return float The logarithm of $number to $base, if given, or the natural logarithm.
     */
    public static function log (float|int $number, float|LogBase $base = LogBase::E):float {

        return log($number, $base instanceof LogBase ? $base->value() : $base);

    }

    /**
     * ### Natural logarithm of 1 + number
     *
     * Returns log(1 + $number), computed accurately even when $number is close to zero.
     * @since 1.0.0
     *
     * @param float|int $number <p>
     * The argument to process.
     * </p>
     *
     * @return float log(1 + num).
     */
    public static function log1p (float|int $number):float {

        return log1p($number);

    }

    /**
     * ### Base-10 logarithm
     *
     * Returns the logarithm of $number in base 10.
     * @since 1.0.0
     *
     * @param float|int $number <p>
     * The argument to process.
     * </p>
     *
     * @return float The base-10 logarithm of num.
     */
    public static function log10 (float|int $number):float {

        return log10($number);

    }

    /**
     * ### Find the highest value
     * @since 1.0.0
     *
     * @template TValue
     *
     * @param TValue $value <p>
     * Any comparable value.
     * </p>
     * @param TValue ...$values <p>
     * Any comparable values.
     * </p>
     *
     * @return TValue Value considered "highest" according to standard comparisons.
     *
     * @caution Be careful when passing arguments of different types because the method can produce unpredictable
     * results.
     */
    public static function max (mixed $value, mixed ...$values):mixed {

        return max([$value, ...$values]);

    }

    /**
     * ### Find the lowest value
     * @since 1.0.0
     *
     * @template TValue
     *
     * @param TValue $value <p>
     * Any comparable value.
     * </p>
     * @param TValue ...$values <p>
     * Any comparable values.
     * </p>
     *
     * @return TValue Value considered "lowest" according to standard comparisons.
     *
     * @caution Be careful when passing arguments of different types because the method can produce unpredictable
     * results.
     */
    public static function min (mixed $value, mixed ...$values):mixed {

        return min([$value, ...$values]);

    }

}