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

namespace FireHub\Tests\Unit\Support\DataStructure\Collection\Linear;

use FireHub\Core\Testing\Base;
use FireHub\Core\Support\DataStructure\DS;
use FireHub\Core\Support\DataStructure\Builder\SequenceBuilder;
use FireHub\Core\Support\DataStructure\Collection\Linear\Sequence;
use FireHub\Core\Shared\Enums\ControlFlow\Signal;
use FireHub\Core\Throwable\Exception\DataStructure\WrongReturnTypeException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Sequence Data Structure
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[CoversClass(DS::class)]
#[CoversClass(SequenceBuilder::class)]
#[CoversClass(Sequence::class)]
final class SequenceTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param array $array
     *
     * @return void
     */
    #[TestWith([6, ['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']])]
    public function testCount (int $expected, array $array):void {

        self::assertSame($expected, DS::sequence()->fromArray($array)->count());

    }

    /**
     * @since 1.0.0
     *
     * @param array $array
     *
     * @return void
     */
    #[TestWith([['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']])]
    public function testTap (array $array):void {

        $ds = DS::sequence()->fromArray($array);

        $called = [];
        $ds->tap(function ($value, $key) use (&$called):void {
            $called[] = $value;
        });

        self::assertSame(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard'], $called);

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

        $ds = DS::sequence()->fromArray($array);

        $called = [];
        $ds->each(function ($value, $key) use (&$called):Signal {
            $called[] = $value;
            return Signal::CONTINUE;
        });

        self::assertSame(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard'], $called);

        $called = [];
        $ds->each(function ($value, $key) use (&$called):Signal {
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
    public function testEachWrongReturnSignal (array $array):void {

        $this->expectException(WrongReturnTypeException::class);

        $called = [];
        DS::sequence()->fromArray($array)->each(function ($value, $key) use (&$called) {
            if ($value === 'Richard') return false;
            $called[] = $value;
            return Signal::CONTINUE;
        });

    }

}