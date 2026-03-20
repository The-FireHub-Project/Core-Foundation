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
use FireHub\Core\Shared\Enums\Data\ResourceType;
use FireHub\Core\Support\LowLevel\Resources;
use FireHub\Tests\DataProviders\ResourceDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Depends, Group, Small, TestWith
};

/**
 * ### Test Low-level resource management helper
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[Group('lowlevel')]
#[CoversClass(Resources::class)]
final class ResourcesTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param resource $resource
     *
     * @return void
     */
    #[DataProviderExternal(ResourceDataProvider::class, 'stream')]
    public function testID (mixed $resource):void {

        $id = Resources::id($resource);

        self::assertIsInt($id);
        self::assertTrue($id > 0);

    }

    /**
     * @since 1.0.0
     *
     * @param resource $resource
     *
     * @return void
     */
    #[DataProviderExternal(ResourceDataProvider::class, 'stream')]
    public function testType (mixed $resource):void {

        self::assertSame(ResourceType::STREAM, Resources::type($resource));

    }

    /**
     * @since 1.0.0
     *
     * @param null|\FireHub\Core\Shared\Enums\Data\ResourceType $type
     *
     * @return void
     */
    #[Depends('testType')]
    #[TestWith([null])]
    #[TestWith([ResourceType::STREAM])]
    public function testActive (?ResourceType $type = null):void {

        self::assertIsArray(Resources::active($type));

    }

}