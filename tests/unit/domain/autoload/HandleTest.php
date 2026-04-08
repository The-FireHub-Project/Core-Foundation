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

namespace FireHub\Tests\Unit\Domain\Autoload;

use FireHub\Core\Testing\Base;
use FireHub\Core\Domain\Autoload\Handle;
use FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidHandleException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Autoload Handle Value Object
 * @since 1.0.0
 */
#[Small]
#[Group('domain')]
#[CoversClass(Handle::class)]
final class HandleTest extends Base {

    /**
     * @since 1.0.0
     *
     * @var \FireHub\Core\Domain\Autoload\Handle
     */
    private static Handle $handle;

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     *
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidHandleException
     *
     * @return void
     */
    #[TestWith(['handle'])]
    public function testCreateHandle (string $name):void {

        self::$handle = new Handle($name);

        self::assertTrue(true);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     *
     * @return void
     */
    #[TestWith([''])]
    public function testInvalidHandleName (string $name):void {

        $this->expectException(InvalidHandleException::class);

        new Handle($name);

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testValue ():void {

        self::assertSame('handle', self::$handle->value());

    }

}