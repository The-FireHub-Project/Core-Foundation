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
use FireHub\Core\Shared\Enums\String\Encoding;
use FireHub\Core\Throwable\Error\LowLevel\Regex\InvalidPatternError;
use FireHub\Core\Support\LowLevel\RegexMB;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Depends, Group, Small, TestWith
};

/**
 * ### Test Regex multibyte low-level proxy class
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[Group('lowlevel')]
#[CoversClass(RegexMB::class)]
final class RegexMBTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $pattern
     * @param string $string
     * @param bool $case_sensitive
     * @param mixed &$result_out
     *
     * @return void
     */
    #[TestWith([true, 'danži', 'Danži is a boy.', false, [0 => 'Danži']])]
    #[TestWith([false, 'danži', 'Danži is a boy.', true, []])]
    public function testMatch (bool $expected, string $pattern, string $string, bool $case_sensitive = true, mixed $result_out = null):void {

        self::assertSame($expected, RegexMB::match($pattern, $string, $case_sensitive, $result));
        self::assertSame($result_out, $result);

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $pattern
     * @param string $replacement
     * @param string $string
     * @param bool $case_sensitive
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Regex\InvalidPatternError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError
     *
     * @return void
     */
    #[TestWith(['PhP, ça marche !', '[é]', 'P', 'éhé, ça marche !'])]
    #[TestWith(['PhP, ça marche !', '[P]', 'P', 'Php, ça marche !', false])]
    public function testReplace (string $expected, string $pattern, string $replacement, string $string, bool $case_sensitive = true):void {

        self::assertSame($expected, RegexMB::replace($pattern, $replacement, $string, $case_sensitive));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $pattern
     * @param string $replacement
     * @param string $string
     * @param bool $case_sensitive
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError
     *
     * @return void
     */
    #[TestWith(['(', '', ''])]
    public function testReplaceInvalidPattern (string $pattern, string $replacement, string $string, bool $case_sensitive = true):void {

        $this->expectException(InvalidPatternError::class);

        RegexMB::replace($pattern, $replacement, $string, $case_sensitive);

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $pattern
     * @param string $string
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Regex\InvalidPatternError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError
     *
     * @return void
     */
    #[TestWith([
        'April fools day is 04/01/2003 and last christmas was 12/24/2002.',
        '(\d{2}/\d{2}/)(\d{4})',
        'April fools day is 04/01/2002 and last christmas was 12/24/2001.',
    ])]
    public function testReplaceFunc (string $expected, string $pattern, string $string):void {

        self::assertSame(
            $expected,
            RegexMB::replaceFunc(
                $pattern,
                static fn($matches) => $matches[1].($matches[2]+1),
                $string
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $pattern
     * @param string $string
     *
     * @return void
     */
    #[TestWith([
        ')',
        'April fools day is 04/01/2002 and last christmas was 12/24/2001.'
    ])]
    public function testReplaceFuncInvalidPattern (string $pattern, string $string):void {

        $this->expectException(InvalidPatternError::class);

        RegexMB::replaceFunc(
            $pattern,
            static fn($matches) => $matches[1].($matches[2]+1),
            $string
        );

    }

    /**
     * @since 1.0.0
     *
     * @param list<string> $expected
     * @param string $pattern
     * @param string $string
     * @param int $limit
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Regex\InvalidPatternError
     *
     * @return void
     */
    #[TestWith([['', 'h', ''], 'é', 'éhé'])]
    public function testSplit (array $expected, string $pattern, string $string, int $limit = -1):void {

        self::assertSame($expected, RegexMB::split($pattern, $string, $limit));

    }

    /**
     * @since 1.0.0
     *
     * @param string $pattern
     * @param string $string
     * @param int $limit
     *
     * @return void
     */
    #[TestWith(['(', ''])]
    public function testSplitInvalidPattern (string $pattern, string $string, int $limit = -1):void {

        $this->expectException(InvalidPatternError::class);

        RegexMB::split($pattern, $string, $limit);

    }

    /**
     * @since 1.0.0
     *
     * @param \FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError
     *
     * @return void
     */
    #[TestWith([Encoding::UTF_8])]
    public function testSetEncoding (Encoding $encoding):void {

        self::assertTrue(RegexMB::encoding($encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param \FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError
     *
     * @return void
     */
    #[TestWith([Encoding::UTF_8])]
    #[Depends('testSetEncoding')]
    public function testGetEncoding (Encoding $encoding):void {

        self::assertSame($encoding, RegexMB::encoding());

    }

}