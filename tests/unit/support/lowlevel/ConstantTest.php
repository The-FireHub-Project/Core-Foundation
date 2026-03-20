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
use FireHub\Core\Throwable\Error\LowLevel\Constant\ {
    AlreadyExistError, NotDefinedError
};
use FireHub\Core\Support\LowLevel\Constant;
use FireHub\Tests\DataProviders\ConstantDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Depends, Group, Small, TestWith
};

/**
 * ### Test low-level Constant proxy class
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[Group('lowlevel')]
#[CoversClass(Constant::class)]
final class ConstantTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     * @param null|array<array-key, mixed>|scalar $value
     *
     * @return void
     */
    #[Depends('testDefine')]
    #[DataProviderExternal(ConstantDataProvider::class, 'types')]
    public function testDefined (string $name, null|array|bool|float|int|string $value):void {

        self::assertTrue( Constant::defined($name));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     * @param null|array<array-key, mixed>|scalar $value
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Constant\AlreadyExistError If constant with the same name already
     * exists.
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Constant\FailedToDefineError If failed to define constant.
     *
     * @return void
     */
    #[DataProviderExternal(ConstantDataProvider::class, 'types')]
    public function testDefine (string $name, null|array|bool|float|int|string $value):void {

        self::assertTrue( Constant::define($name, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     * @param null|array<array-key, mixed>|scalar $value
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Constant\FailedToDefineError If failed to define constant.
     *
     * @return void
     */
    #[DataProviderExternal(ConstantDataProvider::class, 'types')]
    public function testDefineAlreadyExist (string $name, null|array|bool|float|int|string $value):void {

        $this->expectException(AlreadyExistError::class);

        self::assertTrue( Constant::define($name, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     * @param null|array<array-key, mixed>|scalar $value
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Constant\NotDefinedError
     *
     * @return void
     */
    #[Depends('testDefine')]
    #[DataProviderExternal(ConstantDataProvider::class, 'types')]
    public function testValue (string $name, null|array|bool|float|int|string $value):void {

        self::assertSame($value, Constant::value($name));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     *
     * @return void
     */
    #[Depends('testDefine')]
    #[TestWith(['NotDefined'])]
    public function testValueNotFound (string $name):void {

        $this->expectException(NotDefinedError::class);

        Constant::value($name);

    }

}