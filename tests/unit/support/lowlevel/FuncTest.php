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

namespace FireHub\Tests\Unit\Support\LowLevel;

use FireHub\Core\Testing\Base;
use FireHub\Core\Support\LowLevel\Func;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Func low-level proxy class
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[Group('lowlevel')]
#[CoversClass(Func::class)]
final class FuncTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     * @param bool $expected
     *
     * @return void
     */
    #[TestWith(['array_sum', true])]
    #[TestWith(['i_am_not_a_function', false])]
    public function testIsFunction (string $name, bool $expected):void {

        self::assertSame($expected, Func::isFunction($name));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $expected
     *
     * @return void
     */
    #[TestWith(['Hi!'])]
    public function testCall (mixed $expected):void {

        self::assertSame($expected, Func::call(static fn() => $expected));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $expected
     *
     * @return void
     */
    #[TestWith(['Hi!'])]
    public function testCallWithArray (mixed $expected):void {

        self::assertSame($expected, Func::callWithArray(static fn() => $expected, []));

    }

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Func\RegisterTickFailedError
     *
     * @return void
     */
    public function testRegisterFunctions ():void {

        $func = static fn() => 'x';

        self::assertTrue(Func::registerTick($func));

        Func::unregisterTick($func);

        Func::registerShutdown($func);

    }

}