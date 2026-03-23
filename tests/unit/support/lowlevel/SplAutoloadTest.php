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
use FireHub\Core\Support\LowLevel\SplAutoload;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Depends, Group, Small, TestWith
};
use Closure;

/**
 * ### Test SPL autoload management low-level helper
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[Group('lowlevel')]
#[CoversClass(SplAutoload::class)]
final class SplAutoloadTest extends Base {

    /**
     * @since 1.0.0
     *
     * @var Closure
     */
    private Closure $callback = static function ($string) {};

    /**
     * @since 1.0.0
     *
     * @param bool $prepend
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\RegisterAutoloadError
     *
     * @return void
     */
    #[TestWith([])]
    public function testRegister (bool $prepend = false):void {

        self::assertTrue(SplAutoload::register($this->callback, $prepend));

    }

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\UnregisterAutoloaderError
     *
     * @return void
     */
    #[Depends('testRegister')]
    public function testUnregister ():void {

        self::assertTrue(SplAutoload::unregister($this->callback));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testFunctions ():void {

        self::assertIsList(SplAutoload::functions());

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @return void
     */
    #[TestWith(['SplAutoload'])]
    public function testLoad (string $class):void {

        SplAutoload::load($class);

        self::assertTrue(true);

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testExtensions ():void {

        self::assertIsString(SplAutoload::extensions());

    }

}