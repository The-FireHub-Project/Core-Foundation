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

namespace FireHub\Tests\Unit\Shared\Enums;

use FireHub\Core\Testing\Base;
use FireHub\Core\Shared\Enums\Order;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small
};

/**
 * ### Test Sorting order enum
 * @since 1.0.0
 */
#[Small]
#[Group('shared')]
#[Group('enums')]
#[CoversClass(Order::class)]
final class OrderTest extends Base {

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testReverse ():void {

        self::assertSame(Order::DESC, Order::ASC->reverse());

    }

}