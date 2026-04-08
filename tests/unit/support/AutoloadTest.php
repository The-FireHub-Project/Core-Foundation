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

namespace FireHub\Tests\Unit\Support;

use FireHub\Core\Testing\Base;
use FireHub\Core\Support\Autoload;
use FireHub\Core\Domain\Autoload\Handle;
use FireHub\Core\Support\Autoload\Loader\CompiledClassmap;
use FireHub\Core\Throwable\Exception\Domain\Autoload\ImplementationException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test dynamic class autoloading within the FireHub Core framework
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[CoversClass(Autoload::class)]
final class AutoloadTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $handle_name
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\RegisterAutoloadError
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidHandleException
     *
     * @return void
     */
    #[TestWith(['test_append'])]
    public function testAppend (string $handle_name):void {

        Autoload::register(new Handle($handle_name), new CompiledClassmap());

        self::assertTrue(true);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $handle_name
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\RegisterAutoloadError
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidHandleException
     *
     * @return void
     */
    #[TestWith(['test_prepend'])]
    public function testPrepend (string $handle_name):void {

        Autoload::prepend(new Handle($handle_name), new CompiledClassmap());

        self::assertTrue(true);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $handle_name
     *
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\ImplementationException
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\UnregisterAutoloaderError
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidHandleException
     *
     * @return void
     */
    #[TestWith(['test_prepend'])]
    public function testUnregister (string $handle_name):void {

        Autoload::unregister(new Handle($handle_name));

        self::assertTrue(true);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $handle_name
     *
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidHandleException
     *
     * @return void
     */
    #[TestWith(['test_notfound'])]
    public function testInvalidHandleName (string $handle_name):void {

        $this->expectException(ImplementationException::class);

        Autoload::unregister(new Handle($handle_name));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testImplementations ():void {

        self::assertIsList(Autoload::implementations());

        self::assertEquals(new CompiledClassmap(), Autoload::implementations()[0]);

    }

}