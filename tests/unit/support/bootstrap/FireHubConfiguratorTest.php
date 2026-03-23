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

namespace FireHub\Tests\Unit\Support\Bootstrap;

use FireHub\Core\Testing\Base;
use FireHub\Core\FireHub;
use FireHub\Core\Support\Bootstrap\FireHubConfigurator;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Runtime Bootstrap Configuration Builder
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[CoversClass(FireHubConfigurator::class)]
final class FireHubConfiguratorTest extends Base {

    /**
     * @since 1.0.0
     *
     * @var \FireHub\Core\Support\Bootstrap\FireHubConfigurator
     */
    private static FireHubConfigurator $configurator;

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public static function setUpBeforeClass ():void {

        self::$configurator = new FireHubConfigurator();

    }

    /**
     * @since 1.0.0
     *
     * @param array<int|class-string<\FireHub\Core\Support\Bootstrap\Bootloader>, class-string<\FireHub\Core\Support\Bootstrap\Bootloader>|array<array-key, mixed>> $bootloaders
     *
     * @return void
     */
    #[TestWith([[
        \FireHub\Core\Support\Bootstrap\Bootloader\RegisterConstants::class,
        \FireHub\Core\Support\Bootstrap\Bootloader\RegisterHelpers::class
    ]])]
    public function testWithBootloaders (array $bootloaders):void {

        self::assertSame(
            $bootloaders,
            self::$configurator->withBootloaders($bootloaders)->bootloaders
        );

    }

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Throwable\Exception\Bootstrap\FailedToLoadBootloaderException
     * @throws \FireHub\Core\Throwable\Exception\Bootstrap\NotBootloaderException
     *
     * @return void
     */
    public static function testCreate ():void {

        self::assertInstanceOf(FireHub::class, self::$configurator->create());

    }

}