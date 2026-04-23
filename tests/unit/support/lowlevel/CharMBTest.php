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

namespace FireHub\Tests\Unit\Support\LowLevel;

use FireHub\Core\Testing\Base;
use FireHub\Core\Shared\Enums\String\Encoding;
use FireHub\Core\Support\LowLevel\CharMB;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test multibyte character low-level proxy class
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[Group('lowlevel')]
#[CoversClass(CharMB::class)]
final class CharMBTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param int $codepoint
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError
     *
     * @return void
     */
    #[TestWith(['A', 65, Encoding::UTF_8])]
    #[TestWith(['?', 63])]
    #[TestWith(['€', 0x20AC])]
    #[TestWith(['🐘', 128024])]
    public function testChr (string $expected, int $codepoint, ?Encoding $encoding = null):void {

        self::assertSame($expected, CharMB::chr($codepoint, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param int $expected
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError
     *
     * @return void
     */
    #[TestWith(['A', 65, Encoding::UTF_8])]
    #[TestWith(['?', 63])]
    #[TestWith(['€', 0x20AC])]
    #[TestWith(['🐘', 128024])]
    public function testOrd (string $string, int $expected, ?Encoding $encoding = null):void {

        self::assertSame($expected, CharMB::ord($string, $encoding));

    }

}