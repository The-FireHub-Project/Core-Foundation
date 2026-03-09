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
use FireHub\Core\Support\LowLevel\Arr;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

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

}