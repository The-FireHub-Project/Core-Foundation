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

namespace FireHub\Tests\Unit\Support\DataStructure;

use FireHub\Core\Testing\Base;
use FireHub\Core\Support\DataStructure\Collection;
use FireHub\Tests\DataProviders\DataStructureDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Small, TestWith
};

/**
 * ### Test High-level, Eager Array-based Data Structure
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[CoversClass(Collection::class)]
final class CollectionTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param array $array
     *
     * @return void
     */
    #[TestWith([[1,2,3]])]
    public function testIsList (array $array):void {

        self::assertSame($array, new Collection($array)->toArray());

    }

    /**
     * @since 1.0.0
     *
     * @param array $array
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Json\EncodeError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Json\DecodeError
     *
     * @return void
     */
    #[TestWith([['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]])]
    public function testJson (array $array):void {

        $collection = new Collection($array);

        $json = $collection->toJson();

        self::assertSame('{"firstname":"John","lastname":"Doe","age":25,"10":2}', $json);
        self::assertEquals($collection, Collection::fromJson($json));

    }

    /**
     * @since 1.0.0
     *
     * @param array $array
     *
     * @throws \FireHub\Core\Shared\Contracts\Throwable
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\UnserializeFailedError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\CannotSerializeError
     *
     * @return void
     */
    #[TestWith([['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]])]
    public function testSerialize (array $array):void {

        $collection = new Collection($array);

        self::assertEquals($collection, $collection::unserialize($collection->serialize()));

    }

}