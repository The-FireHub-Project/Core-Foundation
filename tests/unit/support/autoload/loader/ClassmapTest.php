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
use FireHub\Core\Support\Autoload\Loader\Classmap;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Classmap Autoload Loader
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[CoversClass(Classmap::class)]
final class ClassmapTest extends Base {

    /**
     * @since 1.0.0
     *
     * @var \FireHub\Core\Support\Autoload\Loader\Classmap
     */
    private static Classmap $classmap;

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testCreateClassmap ():void {

        self::$classmap = new Classmap([
            __CLASS__ => __DIR__.'/ClassmapTest.php',
        ]);

        self::assertTrue(true);

    }

    /**
     * @since 1.0.0
     *
     * @param string $class
     *
     * @return void
     */
    #[TestWith([__CLASS__])]
    #[TestWith(['FireHub\Core\Support\Test'])]
    public function testInvoke (string $class):void {

        (self::$classmap)($class);

        self::assertTrue(true);

    }

}