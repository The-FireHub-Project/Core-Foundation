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

namespace FireHub\Tests\Unit\Shared\Enums\Data;

use FireHub\Core\Testing\Base;
use FireHub\Core\Shared\Enums\Data\ {
    Category, Type
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProvider, Group, Small
};

/**
 * ### Test Data type enum
 * @since 1.0.0
 */
#[Small]
#[Group('shared')]
#[Group('enums')]
#[CoversClass(Type::class)]
final class TypeTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     * @param \FireHub\Core\Shared\Enums\Data\Category $category
     *
     * @return void
     */
    #[DataProvider('provideRoundingModes')]
    public function testCategory (Type $type, Category $category):void {

        self::assertSame($category, $type->category());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testAllCasesAreCategorized():void {

        foreach (Type::cases() as $case)
            self::assertInstanceOf(Category::class, $case->category());

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<\FireHub\Core\Shared\Enums\Data\Type, \FireHub\Core\Shared\Enums\Data\Category>>
     */
    public static function provideRoundingModes():array {

        return [
            [Type::T_BOOL, Category::SCALAR],
            [Type::T_INT, Category::SCALAR],
            [Type::T_FLOAT, Category::SCALAR],
            [Type::T_STRING, Category::SCALAR],
            [Type::T_ARRAY, Category::COMPOUND],
            [Type::T_OBJECT, Category::COMPOUND],
            [Type::T_NULL, Category::SPECIAL],
            [Type::T_RESOURCE, Category::SPECIAL],
            [Type::T_CLOSED_RESOURCE, Category::SPECIAL]
        ];

    }

}