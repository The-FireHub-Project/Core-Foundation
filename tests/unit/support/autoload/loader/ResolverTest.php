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
use FireHub\Core\Support\Autoload\Loader\Resolver;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Resolver Autoload Loader
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[CoversClass(Resolver::class)]
final class ResolverTest extends Base {

    /**
     * @since 1.0.0
     *
     * @var \FireHub\Core\Support\Autoload\Loader\Resolver
     */
    private static Resolver $resolver;

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testCreateResolver ():void {

        self::$resolver = new Resolver();

        self::assertTrue(true);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $namespace_prefix
     * @param non-empty-string $folder
     *
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidFolderException
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidNamespaceException
     *
     * @return void
     */
    #[TestWith(['FireHub\Tests\Unit\Support\LowLevel\\', __DIR__])]
    public function testAddNamespace (string $namespace_prefix, string $folder):void {

        self::$resolver->addNamespace($namespace_prefix, $folder);

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
    #[TestWith(['FireHub\Tests\Unit\Support\LowLevel\Test'])]
    public function testInvoke (string $class):void {

        (self::$resolver)($class);

        self::assertTrue(true);

    }

}