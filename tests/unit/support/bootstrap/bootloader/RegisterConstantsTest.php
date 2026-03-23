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

namespace FireHub\Tests\Unit\Support\Bootstrap\Bootloader;

use FireHub\Core\Testing\Base;
use FireHub\Core\Support\Bootstrap\Bootloader\RegisterConstants;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small
};

/**
 * ### Test Core Runtime Constants Loader
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[CoversClass(RegisterConstants::class)]
final class RegisterConstantsTest extends Base {

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testBoot ():void {

        self::assertTrue(new RegisterConstants()->boot());

    }

}