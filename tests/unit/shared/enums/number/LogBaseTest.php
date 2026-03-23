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

namespace FireHub\Tests\Unit\Shared\Enums\Number;

use FireHub\Core\Testing\Base;
use FireHub\Core\Shared\Enums\Number\LogBase;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProvider, Group, Small
};

/**
 * ### Test Logarithmic base
 * @since 1.0.0
 */
#[Small]
#[Group('shared')]
#[Group('enums')]
#[CoversClass(LogBase::class)]
final class LogBaseTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param \FireHub\Core\Shared\Enums\Number\LogBase $base
     * @param float $expected
     *
     * @return void
     */
    #[DataProvider('provideLogBases')]
    public function testValue (LogBase $base, float $expected):void {

        self::assertSame($expected, $base->value());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testAllEnumCasesAreMapped():void {

        foreach (LogBase::cases() as $case)
            self::assertIsFloat($case->value());

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<\FireHub\Core\Shared\Enums\Number\LogBase, float>>
     */
    public static function provideLogBases():array {

        return [
            [LogBase::E, M_E],
            [LogBase::LOG2E, M_LOG2E],
            [LogBase::LOG10E, M_LOG10E],
            [LogBase::LN2, M_LN2],
            [LogBase::LN10, M_LN10],
        ];

    }

}