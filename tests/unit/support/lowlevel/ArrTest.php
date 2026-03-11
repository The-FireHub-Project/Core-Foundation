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
use FireHub\Core\Shared\Enums\String\CaseFolding;
use \FireHub\Core\Throwable\Error\LowLevel\Arr\ {
    ChunkLengthTooSmallError, KeysAndValuesDiffNumberOfElemsError, OutOfRangeError, SizeInconsistentError
};
use FireHub\Core\Support\LowLevel\Arr;
use FireHub\Tests\DataProviders\ {
    ArrDataProvider, ClassDataProvider
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Small, TestWith
};
use Countable;

/**
 * ### Test array low-level proxy class
 * @since 1.0.0
 */
#[Small]
#[Group('lowlevel')]
#[CoversClass(Arr::class)]
final class ArrTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param array<array-key, mixed> $array
     * @param mixed $result
     *
     * @return void
     */
    #[TestWith([true, [1, 2, 3], 0.5])]
    #[TestWith([true, ['x', 'y', 'z'], 'e'])]
    #[TestWith([false, ['x', 'y', 'z'], 'y'])]
    public function testAll (bool $expected, array $array, mixed $result):void {

        self::assertSame($expected, Arr::all($array, static fn($value) => $value >= $result));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param array<array-key, mixed> $array
     * @param mixed $result
     *
     * @return void
     */
    #[TestWith([true, [1, 2, 3], 2])]
    #[TestWith([false, [1, 2, 3], 2.5])]
    #[TestWith([true, ['x', 'y', 'z'], 'y'])]
    #[TestWith([false, ['x', 'y', 'z'], 'e'])]
    public function testAny (bool $expected, array $array, mixed $result):void {

        self::assertSame($expected, Arr::any($array, static fn($value) => $value === $result));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param array-key $key
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([true, 2, [1, 2, 3]])]
    #[TestWith([false, 3, [1, 2, 3]])]
    #[TestWith([false, 'x', [null, 2, 3]])]
    public function testKeyExist (bool $expected, int|string $key, array $array):void {

        self::assertSame($expected, Arr::keyExist($key, $array));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param array<array-key, mixed> $array
     * @param mixed $value
     *
     * @return void
     */
    #[TestWith([true, [1, 2, 3], 2])]
    #[TestWith([false, [1, 2, 3], 4])]
    #[TestWith([true, [null, 2, 3], null])]
    public function testInArray (bool $expected, array $array, mixed $value):void {

        self::assertSame($expected, Arr::inArray($array, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[DataProviderExternal(ArrDataProvider::class, 'list')]
    public function testIsList (array $array):void {

        self::assertTrue(Arr::isList($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[DataProviderExternal(ArrDataProvider::class, 'associative')]
    #[DataProviderExternal(ArrDataProvider::class, 'multidimensional')]
    public function testIsNotList (array $array):void {

        self::assertFalse(Arr::isList($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, array<array-key, mixed>> $expected
     * @param array<array-key, array<array-key, mixed>> $actual
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\FailedToSortMultiArrayError Failed to sort a multi-sort array.
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\SizeInconsistentError If array sizes are inconsistent.
     *
     * @return void
     */
    #[TestWith([[[0, 10, 100, 100]], [[100, 10, 100, 0]]])]
    public function testMultiSort (array $expected, array $actual):void {

        Arr::multiSort($actual);
        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\FailedToSortMultiArrayError
     *
     * @return void
     */
    #[TestWith([[[], [1, 2]]])]
    public function testMultiSortSizeInconsistent (array $array):void {

        $this->expectException(SizeInconsistentError::class);

        self::assertTrue(Arr::multiSort($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     *
     * @return void
     */
    #[TestWith([['0-x', '1-x', '2-x'], [0, 1, 2]])]
    public function testWalk (array $expected, array $actual):void {

        Arr::walk($actual, static fn(&$value, $key) => $value = $key.'-x');

        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     *
     * @return void
     */
    #[TestWith([[['a' => 'a-x', 'b' => 'b-x'], '1-x', '2-x'], [['a' => 'r','b' => 'g'], '1' => 'b', '2' => 'y']])]
    public function testWalkRecursive (array $expected, array $actual):void {

        Arr::walkRecursive($actual, static fn(&$value, $key) => $value = $key.'-x');

        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param array<array-key, mixed>|Countable $array
     * @param bool $recursive
     *
     * @return void
     */
    #[TestWith([2, [1, 2]])]
    #[TestWith([0, []])]
    #[TestWith([5, [1, 2, [1, 1]], true])]
    public function testCount (int $expected, array|Countable $array, bool $recursive = false):void {

        self::assertSame($expected, Arr::count($array, $recursive));

    }

    /**
     * @since 1.0.0
     *
     * @param Countable $array
     *
     * @return void
     */
    #[DataProviderExternal(ClassDataProvider::class, 'countable')]
    public function testCountWithCountable (Countable $array):void {

        self::assertSame(10, Arr::count($array));

    }

    /**
     * @since 1.0.0
     *
     * @param positive-int[] $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([[1 => 1, 2 => 1], [1, 2]])]
    #[TestWith([[], []])]
    public function testCountValues (array $expected, array $array):void {

        self::assertSame($expected, Arr::countValues($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<int, mixed> $expected
     * @param mixed $value
     * @param int $start_index
     * @param int<0, 2147483648> $length
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\OutOfRangeError
     *
     * @return void
     */
    #[TestWith([[1, 1, 1, 1, 1], 1, 0, 5])]
    #[TestWith([[-2 => 1, -1 => 1, 0 => 1], 1, -2, 3])]
    public function testFill (array $expected, mixed $value, int $start_index, int $length):void {

        self::assertSame($expected, Arr::fill($value, $start_index, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param int $start_index
     * @param int<0, 2147483648> $length
     *
     * @return void
     */
    #[TestWith([1, 0, -5])]
    public function testFillOutOfRangeWithNegativeNumber (mixed $value, int $start_index, int $length):void {

        $this->expectException(OutOfRangeError::class);

        Arr::fill($value, $start_index, $length);

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param int $start_index
     * @param int<0, 2147483648> $length
     *
     * @return void
     */
    #[TestWith([1, 0, PHP_INT_MAX])]
    public function testFillOutOfRangeWithBigNumber (mixed $value, int $start_index, int $length):void {

        $this->expectException(OutOfRangeError::class);

        Arr::fill($value, $start_index, $length);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $keys
     * @param mixed $value
     *
     * @return void
     */
    #[TestWith([[1 => 1, 2 => 1, 3 => 1, '' => 1], [1, 2, 3, null], 1])]
    public function testFillKeys (array $expected, array $keys, mixed $value):void {

        self::assertSame($expected, Arr::fillKeys($keys, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param \FireHub\Core\Shared\Enums\String\CaseFolding $case
     *
     * @return void
     */
    #[TestWith([['ONE' => 1, 'TWO' => 2, 'THREE' => 3], ['one' => 1, 'two' => 2, 'three' => 3], CaseFolding::UPPER])]
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], ['ONE' => 1, 'TWO' => 2, 'THREE' => 3], CaseFolding::LOWER])]
    public function testFoldKeys (array $expected, array $actual, CaseFolding $case):void {

        self::assertSame($expected, Arr::foldKeys($actual, $case));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param positive-int $length
     * @param bool $preserve_keys
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\ChunkLengthTooSmallError
     *
     * @return void
     */
    #[TestWith([[[1, 2], [3]], ['one' => 1, 'two' => 2, 'three' => 3], 2])]
    #[TestWith([[['one' => 1], ['two' => 2], ['three' => 3]], ['one' => 1, 'two' => 2, 'three' => 3], 1, true])]
    public function testChunk (array $expected, array $actual, int $length, bool $preserve_keys = false):void {

        self::assertSame($expected, Arr::chunk($actual, $length, $preserve_keys));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $arr
     * @param positive-int $length
     * @param bool $preserve_keys
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], 0])]
    public function testChunkLengthLessThenZero (array $arr, int $length, bool $preserve_keys = false):void {

        $this->expectException(ChunkLengthTooSmallError::class);

        Arr::chunk($arr, $length, $preserve_keys);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array-key $key
     * @param null|array-key $index
     *
     * @return void
     */
    #[TestWith([[3 => 2, 6 => 5, 9 => 8], ['one' => [1, 2, 3], 'two' => [4, 5, 6], 'three' => [7, 8, 9]], 1, 2])]
    public function testColumn (array $expected, array $actual, int|string $key, null|int|string $index = null):void {

        self::assertSame($expected, Arr::column($actual, $key, $index));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $keys
     * @param array<array-key, mixed> $values
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\KeysAndValuesDiffNumberOfElemsError
     *
     * @return void
     */
    #[TestWith([[1 => 1, 2 => 2, 3 => 3], [1, 2, 3], ['one' => 1, 'two' => 2, 'three' => 3]])]
    #[TestWith([['' => 3], [2 => '', 'x' => null, 5 => false], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testCombine (array $expected, array $keys, array $values):void {

        self::assertSame($expected, Arr::combine($keys, $values));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $keys
     * @param array<array-key, mixed> $values
     *
     * @return void
     */
    #[TestWith([[], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testCombineDiffElementNumber ( array $keys, array $values):void {

        $this->expectException(KeysAndValuesDiffNumberOfElemsError::class);

        Arr::combine($keys, $values);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifference (array $expected, array $actual, array ...$excludes):void {

        self::assertSame($expected, Arr::difference($actual, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceFunc (array $expected, array $actual, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::differenceFunc($actual, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'two') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['firstname' => 'Jane', 'lastname' => 'Doe', 'height' => '160cm']
    ])]
    public function testDifferenceKey (array $expected, array $actual, array ...$excludes):void {

        self::assertSame($expected, Arr::differenceKey($actual, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceKeyFunc (array $expected, array $actual, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::differenceKeyFunc($actual, $excludes,
                static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceAssoc (array $expected, array $actual, array ...$excludes):void {

        self::assertSame($expected, Arr::differenceAssoc($actual, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['age' => 25]
    ])]
    public function testDifferenceAssocFuncValue (array $expected, array $actual, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::differenceAssocFuncValue($actual, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'Doe') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceAssocFuncKey (array $expected, array $actual, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::differenceAssocFuncKey($actual, $excludes,
                static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceAssocFuncKeyValue (array $expected, array $actual, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::differenceAssocFuncKeyValue($actual, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'Doe') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }, static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['lastname' => 'Doe', 'age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersect (array $expected, array $actual, array ...$excludes):void {

        self::assertSame($expected, Arr::intersect($actual, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['lastname' => 'Doe', 'age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectFunc (array $expected, array $actual, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::intersectFunc($actual, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'two') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['firstname' => 'Jane', 'lastname' => 'Doe', 'height' => '160cm']
    ])]
    public function testIntersectKeyFunc (array $expected, array $actual, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::intersectKeyFunc($actual, $excludes,
                static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['firstname' => 'Jane', 'lastname' => 'Doe', 'height' => '160cm']
    ])]
    public function testIntersectKey (array $expected, array $actual, array ...$excludes):void {

        self::assertSame($expected, Arr::intersectKey($actual, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['lastname' => 'Doe', 'age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssoc (array $expected, array $actual, array ...$excludes):void {

        self::assertSame($expected, Arr::intersectAssoc($actual, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssocFuncValue (array $expected, array $actual, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::intersectAssocFuncValue($actual, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'Doe') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssocFuncKey (array $expected, array $actual, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::intersectAssocFuncKey($actual, $excludes,
                static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssocFuncKeyValue (array $expected, array $actual, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::intersectAssocFuncKeyValue($actual, $excludes,
                static function ($value_a, $value_b) {
                    if ($value_a === $value_b && $value_a !== 'Doe') return 0;
                    return ($value_a > $value_b) ? 1 : -1;
                }, static function ($key_a, $key_b) {
                    if ($key_a === $key_b && $key_a !== 'lastname') return 0;
                    return ($key_a > $key_b) ? 1 : -1;
                }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     *
     * @return void
     */
    #[TestWith([['three' => 3], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testFilter (array $expected, array $actual):void {

        self::assertSame(
            $expected,
            Arr::filter($actual, static function ($value, $key) {
                return $key !== 'one' && $value > 2;
            }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     *
     * @return void
     */
    #[TestWith([[0 => 'foo', 2 => -1], [0 => 'foo', 1 => false, 2 => -1, 3 => null, 4 => '', 5 => '0', 6 => 0]])]
    public function testFilterWithoutCallback (array $expected, array $actual):void {

        self::assertSame($expected, Arr::filter($actual));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     *
     * @return void
     */
    #[TestWith([[1 => 'one', 2 => 'two', 3 => 'three'], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testFlip (array $expected, array $actual):void {

        self::assertSame($expected, Arr::flip($actual));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param mixed $filter
     *
     * @return void
     */
    #[TestWith([['one', 'two', 'three'], ['one' => 1, 'two' => 2, 'three' => 3], null])]
    #[TestWith([[''], ['' => 3], null])]
    #[TestWith([['two'], ['one' => 1, 'two' => 2, 'three' => 3], 2])]
    public function testKeys (array $expected, array $array, mixed $filter):void {

        self::assertSame($expected, Arr::keys($array, $filter));

    }

}