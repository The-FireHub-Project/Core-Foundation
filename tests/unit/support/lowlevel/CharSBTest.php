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
use FireHub\Core\Throwable\Error\LowLevel\String\CodepointOutsideValidRangeError;
use FireHub\Core\Support\LowLevel\CharSB;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test single-byte character low-level proxy class
 * @since 1.0.0
 */
#[Small]
#[Group('lowlevel')]
#[CoversClass(CharSB::class)]
final class CharSBTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param int<0, 255> $codepoint
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\CodepointOutsideValidRangeError
     *
     * @return void
     */
    #[TestWith(['!', 33])]
    #[TestWith(['@', 64])]
    #[TestWith(['a', 97])]
    public function testChr (string $string, int $codepoint):void {

        self::assertSame($string, CharSB::chr($codepoint));

    }

    /**
     * @since 1.0.0
     *
     * @param int<0, 255> $codepoint
     *
     * @return void
     */
    #[TestWith([-1])]
    #[TestWith([256])]
    public function testChrOutsideValidRange (int $codepoint):void {

        $this->expectException(CodepointOutsideValidRangeError::class);

        CharSB::chr($codepoint);



    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param int<0, 255> $codepoint
     *
     * @return void
     */
    #[TestWith(['!', 33])]
    #[TestWith(['@', 64])]
    #[TestWith(['a', 97])]
    #[TestWith(['', 0])]
    public function testOrd (string $string, int $codepoint):void {

        self::assertSame($codepoint, CharSB::ord($string));

    }

}