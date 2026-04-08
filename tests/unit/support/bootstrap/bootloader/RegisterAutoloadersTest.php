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

namespace FireHub\Tests\Unit\Support\Bootstrap\Bootloader;

use FireHub\Core\Testing\Base;
use FireHub\Core\Support\Bootstrap\Bootloader\RegisterAutoloaders;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small
};

/**
 * ### Test Framework Autoloaders Registration
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[CoversClass(RegisterAutoloaders::class)]
final class RegisterAutoloadersTest extends Base {

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\RegisterAutoloadError
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidFolderException
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidNamespaceException
     *
     * @return void
     */
    public function testBoot ():void {

        self::assertTrue(new RegisterAutoloaders()->boot());

    }

}