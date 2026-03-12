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
use FireHub\Core\Support\LowLevel\Declared;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small
};

/**
 * ### Test low-level access to declared runtime symbols
 * @since 1.0.0
 */
#[Small]
#[Group('lowlevel')]
#[CoversClass(Declared::class)]
final class DeclaredTest extends Base {

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testClasses ():void {

        self::assertIsList(Declared::classes());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testInterfaces ():void {

        self::assertIsList(Declared::interfaces());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testTraits ():void {

        self::assertIsList(Declared::traits());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testConstants ():void {

        self::assertIsArray(Declared::constants());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testFunctions ():void {

        self::assertIsArray(Declared::functions());

    }

}