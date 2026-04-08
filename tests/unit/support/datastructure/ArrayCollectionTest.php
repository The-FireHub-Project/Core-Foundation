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

namespace FireHub\Tests\Unit\Support\DataStructure;

use FireHub\Core\Testing\Base;
use FireHub\Core\Support\DataStructure\ArrayCollection;
use FireHub\Core\Shared\Enums\ControlFlow\Signal;
use FireHub\Core\Throwable\Exception\DataStructure\WrongReturnTypeException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test High-level, Eager Array-based Data Structure
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[CoversClass(ArrayCollection::class)]
final class ArrayCollectionTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param array $array
     *
     * @return void
     */
    #[TestWith([['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]])]
    public function testFromArray (array $array):void {

        self::assertEquals(new ArrayCollection($array), ArrayCollection::fromArray($array));

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param array $array
     *
     * @return void
     */
    #[TestWith([4, ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]])]
    public function testCount (int $expected, array $array):void {

        self::assertSame($expected, new ArrayCollection($array)->count());

    }

    /**
     * @since 1.0.0
     *
     * @param array $array
     *
     * @return void
     */
    #[TestWith([['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]])]
    public function testToArray (array $array):void {

        self::assertSame($array, new ArrayCollection($array)->toArray());

    }

    /**
     * @since 1.0.0
     *
     * @param array $array
     *
     * @throws \FireHub\Core\Shared\Contracts\Throwable
     * @throws \FireHub\Core\Throwable\Exception\DataStructure\WrongReturnTypeException
     *
     * @return void
     */
    #[TestWith([['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']])]
    public function testEach (array $array):void {

        $collection = new ArrayCollection($array);

        $called = [];
        $collection->each(function ($value, $key) use (&$called):Signal {
            $called[] = $value;
            return Signal::CONTINUE;
        });

        self::assertSame(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard'], $called);

        $called = [];
        $collection->each(function ($value, $key) use (&$called):Signal {
            if ($value === 'Richard') return Signal::BREAK;
            $called[] = $value;
            return Signal::CONTINUE;
        }, limit: 2);

        self::assertSame(['John', 'Jane'], $called);

        $called = [];
        $collection->each(function ($value, $key) use (&$called):Signal {
            if ($value === 'Richard') return Signal::BREAK;
            $called[] = $value;
            return Signal::CONTINUE;
        });

        self::assertSame(['John', 'Jane', 'Jane', 'Jane'], $called);

    }

    /**
     * @since 1.0.0
     *
     * @param array $array
     *
     * @throws \FireHub\Core\Shared\Contracts\Throwable
     *
     * @return void
     */
    #[TestWith([['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']])]
    public function testEachFillOutOfRangeWithNegativeNumber (array $array):void {

        $this->expectException(WrongReturnTypeException::class);

        $called = [];
        new ArrayCollection($array)->each(function ($value, $key) use (&$called) {
            if ($value === 'Richard') return false;
            $called[] = $value;
            return Signal::CONTINUE;
        });

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

        $collection = new ArrayCollection($array);

        $json = $collection->toJson();

        self::assertSame('{"firstname":"John","lastname":"Doe","age":25,"10":2}', $json);
        self::assertEquals($collection, ArrayCollection::fromJson($json));

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

        $collection = new ArrayCollection($array);

        self::assertEquals($collection, $collection::unserialize($collection->serialize()));

    }

}