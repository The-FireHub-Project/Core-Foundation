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
use FireHub\Core\Shared\Enums\ {
    Order, String\Sort, String\CaseFolding
};
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

        var_dump(spl_autoload_functions());
        exit();

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
     * @param array<array-key, mixed> $array
     * @param \FireHub\Core\Shared\Enums\String\CaseFolding $case
     *
     * @return void
     */
    #[TestWith([['ONE' => 1, 'TWO' => 2, 'THREE' => 3], ['one' => 1, 'two' => 2, 'three' => 3], CaseFolding::UPPER])]
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], ['ONE' => 1, 'TWO' => 2, 'THREE' => 3], CaseFolding::LOWER])]
    public function testFoldKeys (array $expected, array $array, CaseFolding $case):void {

        self::assertSame($expected, Arr::foldKeys($array, $case));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param positive-int $length
     * @param bool $preserve_keys
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\ChunkLengthTooSmallError
     *
     * @return void
     */
    #[TestWith([[[1, 2], [3]], ['one' => 1, 'two' => 2, 'three' => 3], 2])]
    #[TestWith([[['one' => 1], ['two' => 2], ['three' => 3]], ['one' => 1, 'two' => 2, 'three' => 3], 1, true])]
    public function testChunk (array $expected, array $array, int $length, bool $preserve_keys = false):void {

        self::assertSame($expected, Arr::chunk($array, $length, $preserve_keys));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     * @param positive-int $length
     * @param bool $preserve_keys
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], 0])]
    public function testChunkLengthLessThenZero (array $array, int $length, bool $preserve_keys = false):void {

        $this->expectException(ChunkLengthTooSmallError::class);

        Arr::chunk($array, $length, $preserve_keys);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array-key $key
     * @param null|array-key $index
     *
     * @return void
     */
    #[TestWith([[3 => 2, 6 => 5, 9 => 8], ['one' => [1, 2, 3], 'two' => [4, 5, 6], 'three' => [7, 8, 9]], 1, 2])]
    public function testColumn (array $expected, array $array, int|string $key, null|int|string $index = null):void {

        self::assertSame($expected, Arr::column($array, $key, $index));

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
    public function testCombineDiffElementNumber (array $keys, array $values):void {

        $this->expectException(KeysAndValuesDiffNumberOfElemsError::class);

        Arr::combine($keys, $values);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifference (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr::difference($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceFunc (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::differenceFunc($array, $excludes,
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
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['firstname' => 'Jane', 'lastname' => 'Doe', 'height' => '160cm']
    ])]
    public function testDifferenceKey (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr::differenceKey($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceKeyFunc (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::differenceKeyFunc($array, $excludes,
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
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceAssoc (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr::differenceAssoc($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['age' => 25]
    ])]
    public function testDifferenceAssocFuncValue (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::differenceAssocFuncValue($array, $excludes,
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
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceAssocFuncKey (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::differenceAssocFuncKey($array, $excludes,
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
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testDifferenceAssocFuncKeyValue (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::differenceAssocFuncKeyValue($array, $excludes,
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
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['lastname' => 'Doe', 'age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersect (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr::intersect($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['lastname' => 'Doe', 'age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectFunc (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::intersectFunc($array, $excludes,
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
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['firstname' => 'Jane', 'lastname' => 'Doe', 'height' => '160cm']
    ])]
    public function testIntersectKeyFunc (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::intersectKeyFunc($array, $excludes,
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
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['firstname' => 'Jane', 'lastname' => 'Doe', 'height' => '160cm']
    ])]
    public function testIntersectKey (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr::intersectKey($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$excludes
     *
     * @return void
     */
    #[TestWith([
        ['lastname' => 'Doe', 'age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssoc (array $expected, array $array, array ...$excludes):void {

        self::assertSame($expected, Arr::intersectAssoc($array, ...$excludes));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssocFuncValue (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::intersectAssocFuncValue($array, $excludes,
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
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssocFuncKey (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::intersectAssocFuncKey($array, $excludes,
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
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> $excludes
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['lastname' => 'Doe', 'age' => 25]
    ])]
    public function testIntersectAssocFuncKeyValue (array $expected, array $array, array $excludes):void {

        self::assertSame(
            $expected,
            Arr::intersectAssocFuncKeyValue($array, $excludes,
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
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([['three' => 3], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testFilter (array $expected, array $array):void {

        self::assertSame(
            $expected,
            Arr::filter($array, static function ($value, $key) {
                return $key !== 'one' && $value > 2;
            }
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([[0 => 'foo', 2 => -1], [0 => 'foo', 1 => false, 2 => -1, 3 => null, 4 => '', 5 => '0', 6 => 0]])]
    public function testFilterWithoutCallback (array $expected, array $array):void {

        self::assertSame($expected, Arr::filter($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([[1 => 'one', 2 => 'two', 3 => 'three'], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testFlip (array $expected, array $array):void {

        self::assertSame($expected, Arr::flip($array));

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

    /**
     * @since 1.0.0
     *
     * @param list[] $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([[1, 2, 3], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testValues (array $expected, array $array):void {

        self::assertSame($expected, Arr::values($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([['one' => '1-x', 'two' => '2-x', 'three' => '3-x'], ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testMap (array $expected, array $array):void {

        self::assertSame($expected, Arr::map($array, static fn($value) => $value.'-x'));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> ...$array
     *
     * @return void
     */
    #[TestWith([
        [1, 2, 3, 'one' => 1, 'two' => 2, 'three' => 3],
        [1, 2, 3],
        ['one' => 1, 'two' => 2, 'three' => 3]
    ])]
    public function testMerge (array $expected, array ...$array):void {

        self::assertSame($expected, Arr::merge(...$array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> ...$arrays
     *
     * @return void
     */
    #[TestWith([
        ['one' => [1, 1], 'two' => [2, 2], 'three' => [3, 3]],
        ['one' => 1, 'two' => 2, 'three' => 3],
        ['one' => 1, 'two' => 2, 'three' => 3]
    ])]
    public function testMergeRecursive (array $expected, array ...$arrays):void {

        self::assertSame($expected, Arr::mergeRecursive(...$arrays));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param int $length
     * @param mixed $value
     *
     * @return void
     */
    #[TestWith([[1, 2, 3, 'x', 'x'], [1, 2, 3], 5, 'x'])]
    #[TestWith([['x', 'x', 1, 2, 3], [1, 2, 3], -5, 'x'])]
    #[TestWith([[1, 2, 3], [1, 2, 3], 2, 'x'])]
    public function testPad (array $expected, array $array, int $length, mixed $value):void {

        self::assertSame($expected, Arr::pad($array, $length, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$replacements
     *
     * @return void
     */
    #[TestWith([
        ['one' => 6, 'two' => 7, 'three' => 3],
        ['one' => 1, 'two' => 2, 'three' => 3],
        ['one' => 6, 'two' => 7]
    ])]
    public function testReplace (array $expected, array $array, array ...$replacements):void {

        self::assertSame($expected, Arr::replace($array, ...$replacements));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param array<array-key, mixed> ...$replacements
     *
     * @return void
     */
    #[TestWith([
        ['one' => [4, 2, 3], 'two' => [4, 5, 6], 'three' => [7, 8, 9]],
        ['one' => [1, 2, 3], 'two' => [4, 5, 6], 'three' => [7, 8, 9]],
        ['one' => [4]]
    ])]
    public function testReplaceRecursive (array $expected, array $array, array ...$replacements):void {

        self::assertSame($expected, Arr::replaceRecursive($array, ...$replacements));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param bool $preserve_keys
     *
     * @return void
     */
    #[TestWith([[3, 2, 1], [1, 2, 3]])]
    #[TestWith([[2 => 3, 1 => 2, 0 => 1], [1, 2, 3], true])]
    public function testReverse (array $expected, array $array, bool $preserve_keys = false):void {

        self::assertSame($expected, Arr::reverse($array, $preserve_keys));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param int $offset
     * @param null|int $length
     * @param bool $preserve_keys
     *
     * @return void
     */
    #[TestWith([[2, 3], [1, 2, 3], 1])]
    #[TestWith([[1 => 2, 2 => 3], [1, 2, 3], 1, null, true])]
    #[TestWith([[0 => 3], [1, 2, 3], -1])]
    public function testSlice (array $expected, array $array, int $offset, ?int $length = null, bool $preserve_keys =
    false):void {

        self::assertSame($expected, Arr::slice($array, $offset, $length, $preserve_keys));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     * @param int $offset
     * @param null|int $length
     * @param array<array-key, mixed> $replacement
     *
     * @return void
     */
    #[TestWith([[3], [1, 2, 3], 0, 2, []])]
    #[TestWith([[5, 3], [1, 2, 3], 0, 2, [5]])]
    #[TestWith([[1, 3], [1, 2, 3], -2, 1, []])]
    #[TestWith([[1, 3], [1, 2, 3], -2, 1, []])]
    public function testSplice (array $expected, array $array, int $offset, ?int $length = null, mixed $replacement = []):void {

        Arr::splice($array, $offset, $length, $replacement);

        self::assertSame($expected, $array);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([[0 => 1, 3 => 2, 4 => 3], [1, 1, 1, 2, 3]])]
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], ['one' => 1, 'one2' => 1, 'two' => 2, 'three' => 3]])]
    public function testUnique (array $expected, array $array):void {

        self::assertSame($expected, Arr::unique($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param int|float|string $start
     * @param int|float|string $end
     * @param positive-int|float $step
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\OutOfRangeError
     *
     * @return void
     */
    #[TestWith([[1, 3, 5, 7, 9], 1, 10, 2])]
    public function testRange (array $expected, int|float|string $start, int|float|string $end, int|float $step = 1):void {

        self::assertSame($expected, Arr::range($start, $end, $step));

    }

    /**
     * @since 1.0.0
     *
     * @param int|float|string $start
     * @param int|float|string $end
     * @param positive-int|float $step
     *
     * @return void
     */
    #[TestWith([1, 10, -2])]
    public function testRangeNegativeStep (int|float|string $start, int|float|string $end, int|float $step):void {

        $this->expectException(OutOfRangeError::class);

        Arr::range($start, $end, $step);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\OutOfRangeError
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testRandom (array $array):void {

        self::assertArrayHasKey(Arr::random($array), $array);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     * @param positive-int $number
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\OutOfRangeError
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], 2])]
    public function testRandomMultiple (array $array, int $number):void {

        $expected = Arr::random($array, $number);

        self::assertIsArray($expected);
        self::assertCount(2, $expected);

        foreach ($expected as $key)
            self::assertArrayHasKey($key, $array);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     * @param positive-int $number
     *
     * @return void
     */
    #[TestWith([[1, 1, 1, 2, 3], 10])]
    public function testRandomBiggerThenArray (array $array, int $number):void {

        $this->expectException(OutOfRangeError::class);

        Arr::random($array, $number);

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $expected
     * @param array<array-key, mixed> $array
     * @param mixed $initial
     *
     * @return void
     */
    #[TestWith([6, [1, 2, 3]])]
    #[TestWith([9, [1, 2, 3], 3])]
    public function testReduce (mixed $expected, array $array, mixed $initial = null):void {

        if ($initial === null)
            self::assertSame($expected, Arr::reduce($array, static fn($carry, $item) => $carry + $item));
        else
            self::assertSame($expected, Arr::reduce($array, static fn($carry, $item) => $carry + $item, $initial));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     *
     * @return void
     */
    #[TestWith([[1, 2], [1, 2, 3]])]
    public function testPop (array $expected, array $actual):void {

        Arr::pop($actual);

        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param mixed ...$values
     *
     * @return void
     */
    #[TestWith([[1, 2, 3, 4], [1, 2, 3], 4])]
    public function testPush (array $expected, array $actual, mixed ...$values):void {

        Arr::push($actual, ...$values);

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
    #[TestWith([[2, 3], [1, 2, 3]])]
    public function testShift (array $expected, array $actual):void {

        Arr::shift($actual);

        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param mixed ...$values
     *
     * @return void
     */
    #[TestWith([[0, 1, 2, 3], [1, 2, 3], 0])]
    public function testUnshift (array $expected, array $actual, mixed ...$values):void {

        Arr::unshift($actual, ...$values);

        self::assertSame($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param null|array-key $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([1, ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testFirst (mixed $expected, array $array):void {

        self::assertSame($expected, Arr::first($array));

    }

    /**
     * @since 1.0.0
     *
     * @param null|array-key $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([3, ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testLast (mixed $expected, array $array):void {

        self::assertSame($expected, Arr::last($array));

    }

    /**
     * @since 1.0.0
     *
     * @param null|array-key $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith(['one', ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testFirstKey (null|int|string $expected, array $array):void {

        self::assertSame($expected, Arr::firstKey($array));

    }

    /**
     * @since 1.0.0
     *
     * @param null|array-key $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith(['three', ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testLastKey (null|int|string $expected, array $array):void {

        self::assertSame($expected, Arr::lastKey($array));

    }

    /**
     * @since 1.0.0
     *
     * @param int|float $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([6, ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testProduct (int|float $expected, array $array):void {

        self::assertSame($expected, Arr::product($array));

    }

    /**
     * @since 1.0.0
     *
     * @param int|float $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([6, ['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testSum (int|float $expected, array $array):void {

        self::assertSame($expected, Arr::sum($array));

    }

    /**
     * @since 1.0.0
     *
     * @param int|string|false $expected
     * @param array<array-key, mixed> $array
     * @param mixed $value
     *
     * @return void
     */
    #[TestWith(['two', ['one' => 1, 'two' => 2, 'three' => 3], 2])]
    #[TestWith([false, ['one' => 1, 'two' => 2, 'three' => 3], 5])]
    public function testSearch (int|string|false $expected, array $array, mixed $value):void {

        self::assertSame($expected, Arr::search($array, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([2, ['one' => 1, 'two' => 2, 'three' => 3]])]
    #[TestWith([null, ['one' => 1, 'three' => 3]])]
    public function testFind (mixed $expected, array $array):void {

        self::assertSame(
            $expected,
            Arr::find($array, static fn($value, $key) => $value === 2)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param null|array-key $expected
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith(['two', ['one' => 1, 'two' => 2, 'three' => 3]])]
    #[TestWith([null, ['one' => 1, 'three' => 3]])]
    public function testFindKey (mixed $expected, array $array):void {

        self::assertSame(
            $expected,
            Arr::findKey($array, static fn($value, $key) => $value === 2)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $array
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3]])]
    public function testInternalPointers (array $array):void {

        Arr::reset($array);

        self::assertSame(1, Arr::current($array));

        self::assertSame(2, Arr::next($array));

        self::assertSame(1, Arr::prev($array));

        self::assertSame(3, Arr::end($array));

        self::assertSame('three', Arr::key($array));

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $actual
     *
     * @return void
     */
    #[DataProviderExternal(ArrDataProvider::class, 'list')]
    public function testShuffle (array $actual):void {

        $expected = $actual;

        Arr::shuffle($actual);

        self::assertArraysAreEqualIgnoringOrder($expected, $actual);

    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param \FireHub\Core\Shared\Enums\Order $order
     * @param \FireHub\Core\Shared\Enums\String\Sort $flag
     * @param bool $preserve_keys
     *
     * @return void
     */
    #[TestWith([
        ['male', 'John', 'Doe', 25, '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male']
    ])]
    #[TestWith([
        ['gender' => 'male', 'firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male'],
        Order::ASC,
        Sort::BY_REGULAR,
        true
    ])]
    #[TestWith([
        ['firstname' => 'John', 'lastname' => 'Doe', 'gender' => 'male', 'age' => 25, 'height' => '190cm'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male'],
        Order::DESC,
        Sort::BY_NUMERIC,
        true
    ])]
    public function testSort (array $expected, array $actual, Order $order = Order::ASC, Sort $flag = Sort::BY_REGULAR, bool $preserve_keys = false):void {

        Arr::sort($actual, $order->reverse(), $flag, $preserve_keys);

        self::assertSame($expected, $actual);
    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param \FireHub\Core\Shared\Enums\Order $order
     * @param \FireHub\Core\Shared\Enums\String\Sort $flag
     *
     * @return void
     */
    #[TestWith([
        ['age' => 25, 'firstname' => 'John', 'gender' => 'male', 'height' => '190cm', 'lastname' => 'Doe'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male']
    ])]
    #[TestWith([
        ['lastname' => 'Doe', 'height' => '190cm', 'gender' => 'male', 'firstname' => 'John', 'age' => 25],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male'],
        Order::DESC,
        Sort::BY_STRING
    ])]
    public function testSortByKeys (array $expected, array $actual, Order $order = Order::ASC, Sort $flag = Sort::BY_REGULAR):void {

        Arr::sortByKeys($actual, $order, $flag);

        self::assertSame($expected, $actual);
    }

    /**
     * @since 1.0.0
     *
     * @param array<array-key, mixed> $expected
     * @param array<array-key, mixed> $actual
     * @param bool $preserve_keys
     *
     * @return void
     */
    #[TestWith([
        ['190cm', 25, 'Doe', 'John', 'male'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male']
    ])]
    #[TestWith([
        ['height' => '190cm', 'age' => 25, 'lastname' => 'Doe', 'firstname' => 'John', 'gender' => 'male'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male'],
        true
    ])]
    public function testSortBy (array $expected, array $actual, bool $preserve_keys = false):void {

        Arr::sortBy($actual, static function ($current, $next) {
            if ($current === $next) return 0;
            return ($current < $next) ? -1 : 1;
        }, $preserve_keys);

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
    #[TestWith([
        ['age' => 25, 'firstname' => 'John', 'gender' => 'male', 'height' => '190cm', 'lastname' => 'Doe'],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 'height' => '190cm', 'gender' => 'male']
    ])]
    public function testSortKeysBy (array $expected, array $actual):void {

        Arr::sortKeysBy($actual, static function ($current, $next) {
            if ($current === $next) return 0;
            return ($current < $next) ? -1 : 1;
        });

        self::assertSame($expected, $actual);

    }

}