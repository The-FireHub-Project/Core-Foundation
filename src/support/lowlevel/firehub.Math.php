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
use FireHub\Core\Throwable\Error\LowLevel\Number\ {
    ArithmeticError, DivideByZeroError
};
use ArithmeticError as InternalArithmeticError;

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
     * ### Finds whether a value is a legal finite number
     *
     * Checks whether the $number is legally finite on this platform.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The value to check.
     * </p>
     *
     * @return bool True if number is a legal finite number within the allowed range for a PHP float on this platform,
     * false otherwise.
     */
    public static function isFinite (float $number):bool {

        return is_finite($number);

    }

    /**
     * ### Finds whether a value is infinite
     *
     * Returns true if a num is infinite (positive or negative), like the result of log(0) or any value too big to fit
     * into a float on this platform.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The value to check.
     * </p>
     *
     * @return bool True if the number is infinite, false otherwise.
     */
    public static function isInfinite (float $number):bool {

        return is_infinite($number);

    }

    /**
     * ### Finds whether a value is not a number
     *
     * Checks whether a num is 'not a number', like the result of acos(1.01).
     * @since 1.0.0
     *
     * @param float $number <p>
     * Value to check.
     * </p>
     *
     * @return bool True if a number is 'not a number', false otherwise.
     */
    public static function isNan (float $number):bool {

        return is_nan($number);

    }

    /**
     * ### Integer division
     * @since 1.0.0
     *
     * @param int $dividend <p>
     * Number to be divided.
     * </p>
     * @param non-zero-int $divisor <p>
     * Number which divides the $dividend.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Number\ArithmeticError If the $dividend is PHP_INT_MIN and the
     * $divisor is -1.
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Number\DivideByZeroError If $divisor is 0.
     *
     * @return int The integer quotient of the division of $dividend by $divisor.
     */
    public static function divideIntegers (int $dividend, int $divisor):int {

        if ($divisor === 0) throw new DivideByZeroError;

        try {

            return intdiv($dividend, $divisor);

        } catch (InternalArithmeticError $error) {

            throw new ArithmeticError($error->getMessage());

        }

    }

    /**
     * ### Divides two numbers, according to IEEE 754
     *
     * Returns the floating point result of dividing the num1 by the num2.<br>
     * If the num2 is zero, then one of INF, -INF, or NAN will be returned.
     * @since 1.0.0
     *
     * @param float $dividend <p>
     * Number to be divided.
     * </p>
     * @param float $divisor <p>
     * Number which divides the $dividend.
     * </p>
     *
     * @return float The floating point result of the division of $dividend by $divisor.
     */
    public static function divideFloats (float $dividend, float $divisor):float {

        return fdiv($dividend, $divisor);

    }

    /**
     * ### Get the floating point remainder (modulo) of the division of the arguments
     *
     * Returns the floating point remainder of dividing the dividend ($dividend) by the divisor ($divisor).<br>
     * The remainder (r) is defined as: $dividend = i * $divisor + r, for some integer i.<br>
     * If $divisor is non-zero, r has the same sign as $dividend and a magnitude less than the size of $divisor.
     * @since 1.0.0
     *
     * @param float $dividend <p>
     * The dividend.
     * </p>
     * @param float $divisor <p>
     * The divisor.
     * </p>
     *
     * @return float The floating point remainder (modulo) of the division for the arguments.
     */
    public static function remainder (float $dividend, float $divisor):float {

        return fmod($dividend, $divisor);

    }

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

    /**
     * ### Exponential expression
     * @since 1.0.0
     *
     * @param float|int $base <p>
     * The base to use.
     * </p>
     * @param float|int $exponent <p>
     * The exponent.
     * </p>
     *
     * @return (
     *   $base is non-negative-int
     *     ? ($exponent is non-negative-int
     *       ? int
     *       : float)
     *     : float
     * ) If both arguments are non-negative integers and the result can be represented as an integer, the result will
     * be returned with an int type, otherwise it will be returned as a float.
     *
     * @note It is possible to use the ** operator instead.
     */
    public static function power (float|int $base, float|int $exponent):float|int {

        return pow($base, $exponent);

    }

    /**
     * ### Format a number with grouped thousands
     *
     * Formats a number with grouped thousands and optionally decimal digits using the rounding half-up rule.
     * @since 1.0.0
     *
     * @param int|float $number <p>
     * The number being formatted.
     * </p>
     * @param int $decimals <p>
     * Sets the number of decimal digits.<br>
     * If 0, the decimal_separator is omitted from the return value.<br>
     * When the value is negative, the num is rounded to decimal significant digits before the decimal point.
     * </p>
     * @param string $decimal_separator [optional] <p>
     * Sets the separator for the decimal point.
     * </p>
     * @param string $thousands_separator [optional] <p>
     * Sets the separator for thousands.
     * </p>
     *
     * @return non-empty-string A formatted version of the number.
     */
    public static function format (int|float $number, int $decimals, string $decimal_separator = '.', string $thousands_separator = ','):string {

        /** @var non-empty-string */
        return number_format(
            $number,
            $decimals,
            $decimal_separator,
            $thousands_separator
        );

    }

    /**
     * ### Converts the number in degrees to the radian equivalent
     * @since 1.0.0
     *
     * @param int|float $number <p>
     * Angular value in degrees.
     * </p>
     *
     * @return float Radian equivalent of number.
     */
    public static function degreesToRadian (int|float $number):float {

        return deg2rad($number);

    }

    /**
     * ### Converts the radian number to the equivalent number in degrees
     * @since 1.0.0
     *
     * @param int|float $number <p>
     * Radian value.
     * </p>
     *
     * @return float Equivalent of number in degrees.
     */
    public static function radianToDegrees (int|float $number):float {

        return rad2deg($number);

    }

    /**
     * ### Calculates the exponent of e
     * @since 1.0.0
     *
     * @param int|float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float 'e' raised to the power of number.
     *
     * @note 'e' is the base of the natural system of logarithms, or approximately 2.718282.
     */
    public static function exponent (int|float $number):float {

        return exp($number);

    }

    /**
     * ### Returns exp($number) – 1, computed in a way that is accurate even when the value of the number is close to zero
     *
     * Method returns the equivalent to 'exp(num) – 1' computed in a way that is accurate even if the value of num is
     * near zero, a case where 'exp (num) – 1' would be inaccurate due to subtraction of two numbers that are nearly
     * equal.
     * @since 1.0.0
     *
     * @param int|float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float 'e' raised to the power of number.
     *
     * @note 'e' to the power of num minus one.
     */
    public static function exponent1 (int|float $number):float {

        return expm1($number);

    }

    /**
     * ### Calculate the length of the hypotenuse of a right-angle triangle
     *
     * Method returns the length of the hypotenuse of a right-angle triangle with sides of length x and y, or the
     * distance of the point (x, y) from the origin.<br>
     * This is equivalent to sqrt($x*$x + $y*$y).
     * @since 1.0.0
     *
     * @param int|float $x <p>
     * Length of the first side.
     * </p>
     * @param int|float $y <p>
     * Length of the second side.
     * </p>
     *
     * @return float Calculated length of the hypotenuse.
     */
    public static function hypotenuseLength (int|float $x, int|float $y):float {

        return hypot($x, $y);

    }

    /**
     * ### Square root
     * @since 1.0.0
     *
     * @param int|float $number  <p>
     * The argument to process.
     * </p>
     *
     * @return float The square root of a num or the special value NAN for negative numbers.
     */
    public static function squareRoot (int|float $number):float {

        return sqrt($number);

    }

    /**
     * ### Cosine
     *
     * Method returns the cosine of the $number parameter.<br>
     * The $number parameter is in radians.
     * @since 1.0.0
     *
     * @param float $number <p>
     * An angle in radians.
     * </p>
     *
     * @return float The cosine of an angle.
     */
    public static function cosine (float $number):float {

        return cos($number);

    }

    /**
     * ### Arc cosine
     *
     * Returns the arc cosine of num in radians.<br>
     * NumFloat#cosineArc() is the inverse function of NumFloat#cosine() which means that
     * $number == NumFloat#cosine(NumFloat#cosineArc($number)) for every value of a that is within NumFloat#cosineArc()
     * range.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float The arc cosine of the number in radians.
     */
    public static function cosineArc (float $number):float {

        return acos($number);

    }

    /**
     * ### Hyperbolic cosine
     *
     * Returns the hyperbolic cosine of $number, defined as (exponent($number) + exponent(-$number))/2.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float Hyperbolic cosine of number.
     */
    public static function cosineHyperbolic (float $number):float {

        return cosh($number);

    }

    /**
     * ### Inverse hyperbolic cosine
     *
     * Returns the inverse hyperbolic cosine of $number, in other words, the value whose hyperbolic cosine is $number.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float Inverse hyperbolic cosine of number.
     */
    public static function cosineInverseHyperbolic (float $number):float {

        return acosh($number);

    }

    /**
     * ### Sine
     *
     * Method returns the sine of the num parameter.<br>
     * The num parameter is in radians.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float Sine of number.
     */
    public static function sine (float $number):float {

        return sin($number);

    }

    /**
     * ### Arc sine
     *
     * Returns the arc sine of $number in radians.<br>
     * NumFloat#sineArc() is the inverse function of NumFloat#sine(), which means that $num ==
     * NumFloat#sine(NumFloat#sineArc($number)) for every value of a that is within NumFloat#sineArc() range.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float The arc sine of number in radians.
     */
    public static function sineArc (float $number):float {

        return asin($number);

    }

    /**
     * ### Hyperbolic sine
     *
     * Returns the hyperbolic sine of num, defined as (exponent($number) – exponent(-$number))/2.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float Hyperbolic sine of number.
     */
    public static function sineHyperbolic (float $number):float {

        return sinh($number);

    }

    /**
     * ### Inverse hyperbolic tangent
     *
     * Returns the inverse hyperbolic sine of $number, in other words, the value whose hyperbolic sine is $number.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float The inverse hyperbolic sine of number.
     */
    public static function sineHyperbolicInverse (float $number):float {

        return asinh($number);

    }

    /**
     * ### Tangent
     *
     * Returns the tangent of the num parameter.<br>
     * The num parameter is in radians.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The argument to process in radians.
     * </p>
     *
     * @return float Tangent of number.
     */
    public static function tangent (float $number):float {

        return tan($number);

    }

    /**
     * ### Arc tangent
     *
     * Returns the arc tangent of num in radians.<br>
     * NumFloat#tangentArc() is the inverse function of NumFloat#tangent(), which means that $num ==
     * NumFloat#tangent(NumFloat#tangentArc($number)) for every value of a that is within NumFloat#tangentArc() range.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float Arc tangent of num in radians.
     */
    public static function tangentArc (float $number):float {

        return atan($number);

    }

    /**
     * ### Arc tangent of two variables
     *
     * This method calculates the arc tangent of the two variables x and y.<br>
     * It is similar to calculating the arc tangent of y / x, except that the signs of both arguments are used to
     * determine the quadrant of the result.<br>
     * The function returns the result in radians, which is between -PI and PI (inclusive).
     * @since 1.0.0
     *
     * @param float $x <p>
     * Divisor parameter.
     * </p>
     * @param float $y <p>
     * Dividend parameter.
     * </p>
     *
     * @return float Arc tangent of y/x in radians.
     */
    public static function tangentArc2 (float $x, float $y):float {

        return atan2($y, $x);

    }

    /**
     * ### Hyperbolic tangent
     *
     * Returns the hyperbolic tangent of $number, defined as sineHyperbolic($number)/cosineHyperbolic($number).
     * @since 1.0.0
     *
     * @param float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float Hyperbolic tangent of number.
     */
    public static function tangentHyperbolic (float $number):float {

        return tanh($number);

    }

    /**
     * ### Inverse hyperbolic tangent
     *
     * Returns the inverse hyperbolic tangent of $number, in other words, the value whose hyperbolic tangent is $number.
     * @since 1.0.0
     *
     * @param float $number <p>
     * The argument to process.
     * </p>
     *
     * @return float Inverse hyperbolic tangent of $number.
     */
    public static function tangentInverseHyperbolic (float $number):float {

        return atanh($number);

    }

}