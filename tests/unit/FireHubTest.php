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

namespace FireHub\Tests\Unit;

use FireHub\Core\Testing\Base;
use FireHub\Core\FireHub;
use FireHub\Core\Support\Bootstrap\FireHubConfigurator;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Small
};

/**
 * ### Test Core Runtime Orchestrator
 * @since 1.0.0
 */
#[Small]
#[CoversClass(FireHub::class)]
final class FireHubTest extends Base {

    /**
     * @since 1.0.0
     *
     * @var \FireHub\Core\FireHub
     */
    private static FireHub $firehub;

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Throwable\Exception\Bootstrap\FailedToLoadBootloaderException
     * @throws \FireHub\Core\Throwable\Exception\Bootstrap\NotBootloaderException
     *
     * @return void
     */
    public static function testCreate ():void {

        self::$firehub = new FireHub(new FireHubConfigurator());

        self::assertTrue(true);

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public static function testBoot ():void {

        self::assertIsString(self::$firehub->boot());

    }

}