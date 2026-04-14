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

namespace FireHub\Tests\Unit\Support\DataStructure\Storage;

use FireHub\Core\Testing\Base;
use FireHub\Core\Support\DataStructure\Storage\ArrStorage;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Array-Based Storage
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[CoversClass(ArrStorage::class)]
final class ArrStorageTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param array $array
     *
     * @return void
     */
    #[TestWith([['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']])]
    public function testEntries (array $array):void {

        self::assertSame($array, new ArrStorage($array)->entries());

    }

    /**
     * @since 1.0.0
     *
     * @param array $expected
     * @param array $array
     *
     * @return void
     */
    #[TestWith([
        ['firstname', 'lastname', 'age', 10],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]
    ])]
    public function testKeys (array $expected, array $array):void {

        self::assertSame($expected, new ArrStorage($array)->keys());

    }

    /**
     * @since 1.0.0
     *
     * @param array $expected
     * @param array $array
     *
     * @return void
     */
    #[TestWith([
        ['John', 'Doe', 25, 2],
        ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]
    ])]
    public function testValues (array $expected, array $array):void {

        self::assertSame($expected, new ArrStorage($array)->values());

    }

}