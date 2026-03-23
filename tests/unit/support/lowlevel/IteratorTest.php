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
use FireHub\Tests\DataProviders\ClsObjDataProvider;
use FireHub\Core\Support\LowLevel\Iterator;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Small
};

/**
 * ### Test Iterator low-level proxy class
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[Group('lowlevel')]
#[CoversClass(Iterator::class)]
final class IteratorTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param iterable $iterator
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'iterator')]
    public function testToArray (iterable $iterator):void {

        self::assertSame([1 => 'one', 2 => 'two', 3 => 'three'], Iterator::toArray($iterator));
        self::assertSame(['one', 'two', 'three'], Iterator::toArray($iterator, false));

    }

    /**
     * @since 1.0.0
     *
     * @param iterable<mixed, mixed> $iterator
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'iterator')]
    public function testCount (iterable $iterator):void {

        self::assertSame(3, Iterator::count($iterator));

    }

    /**
     * @since 1.0.0
     *
     * @param iterable $iterator
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'splFixedArray')]
    public function testApply (iterable $iterator):void {

        Iterator::apply($iterator, static function (...$param) use ($iterator) {
            foreach ($param as $key => $value) {
                $iterator[$key] = $value + 1;
            }
            return true;

        },$iterator->toArray());

        self::assertSame([2, 3, 4], $iterator->toArray());

    }

}