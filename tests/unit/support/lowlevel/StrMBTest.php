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
use FireHub\Core\Shared\Enums\Side;
use FireHub\Core\Shared\Enums\String\ {
    CaseFolding, Encoding
};
use FireHub\Core\Throwable\Error\LowLevel\String\ChunkLengthLessThanOneError;
use FireHub\Core\Support\LowLevel\StrMB;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Multibyte string low-level proxy class
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[Group('lowlevel')]
#[CoversClass(StrMB::class)]
final class StrMBTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param \FireHub\Core\Shared\Enums\String\CaseFolding $case_folding
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['ĐŠČĆŽ 诶杰艾玛 ЛЙ ÈSSÁ カタカナ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', CaseFolding::UPPER])]
    #[TestWith(['đščćž 诶杰艾玛 лй èssá カタカナ', 'ĐŠČĆŽ 诶杰艾玛 ЛЙ ÈSSÁ カタカナ', CaseFolding::LOWER])]
    #[TestWith(['Đščćž 诶杰艾玛 Лй Èßá カタカナ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', CaseFolding::TITLE])]
    public function testConvert (string $expected, string $string, CaseFolding $case_folding, ?Encoding $encoding = null):void {

        self::assertSame($expected, StrMB::convert($string, $case_folding, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['Đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    public function testCapitalize (string $expected, string $string):void {

        self::assertSame($expected, StrMB::capitalize($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'Đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    public function testDeCapitalize (string $expected, string $string):void {

        self::assertSame($expected, StrMB::deCapitalize($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param int $start
     * @param null|int $length
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 6])]
    #[TestWith(['ЛЙ È', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 11, 4])]
    #[TestWith(['カタカ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', -4, 3])]
    public function testPart (string $expected, string $string, int $start, ?int $length = null, ?Encoding $encoding = null):void {

        self::assertSame($expected, StrMB::part($string, $start, $length, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $find
     * @param string $string
     * @param bool $before_needle
     * @param bool $case_sensitive
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['诶杰艾玛 ЛЙ ÈßÁ カタカナ', '诶杰艾玛', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith(['đščćž 诶杰艾玛', ' ЛЙ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', true])]
    #[TestWith(['čćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'Č', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false, false])]
    public function testFirstOccurrence (string $expected, string $find, string $string, bool $before_needle = false, bool $case_sensitive = true, ?Encoding $encoding = null):void {

        self::assertSame($expected, StrMB::firstOccurrence($find, $string, $before_needle, $case_sensitive, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $find
     * @param string $string
     * @param bool $before_needle
     * @param bool $case_sensitive
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['诶杰艾玛 ЛЙ ÈßÁ カタカナ', '诶杰艾玛', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith(['đščćž 诶杰艾玛', ' ЛЙ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', true])]
    #[TestWith(['čćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', 'Č', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false, false])]
    public function testLastCharacterFrom (string $expected, string $find, string $string, bool $before_needle = false, bool $case_sensitive = true, ?Encoding $encoding = null):void {

        self::assertSame($expected, StrMB::lastCharacterFrom($find, $string, $before_needle, $case_sensitive,
            $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param \FireHub\Core\Shared\Enums\Side $side
     * @param string $characters
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([
        "ÈßÁ カタカナЙÈßÁ カタカナ :) ...  \n\r",
        "\t\tÈßÁ カタカナЙÈßÁ カタカナ :) ...  \n\r",
        Side::LEFT,
        " \n\r\t\v\x00"
    ])]
    #[TestWith([
        "\t\tÈßÁ カタカナЙÈßÁ カタカナ :) ...",
        "\t\tÈßÁ カタカナЙÈßÁ カタカナ :) ...",
        Side::RIGHT,
        " \n\r\t\v\x00"
    ])]
    #[TestWith([
        "ÈßÁ カタカナЙÈßÁ カタカナ :) ...",
        "\t\tÈßÁ カタカナЙÈßÁ カタカナ :) ...  \n\r",
        Side::BOTH,
        " \n\r\t\v\x00"
    ])]
    public function testTrim (string $expected, string $string, Side $side = Side::BOTH, ?string $characters = null, ?Encoding $encoding = null):void {

        self::assertSame($expected, StrMB::trim($string, $side, $characters, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param list<non-empty-string> $expected
     * @param non-empty-string $string
     * @param positive-int $length
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\ChunkLengthLessThanOneError
     *
     * @return void
     */
    #[TestWith([
        [
            0 => 'đščćž',
            1 => ' 诶杰艾玛',
            2 => ' ЛЙ È',
            3 => 'ßÁ カタ',
            4 => 'カナ'
        ],
        'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ',
        5
    ])]
    public function testSplit (array $expected, string $string, int $length = 1, ?Encoding $encoding = null):void {

        self::assertSame($expected, StrMB::split($string, $length, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $string
     * @param positive-int $length
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @return void
     */
    #[TestWith(['The lazy fox jumped over the fence', 0])]
    public function testSplitLengthLessThanOne (string $string, int $length = 1, ?Encoding $encoding = null):void {

        $this->expectException(ChunkLengthLessThanOneError::class);

        StrMB::split($string, $length, $encoding);

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     * @param string $search
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([2, 'ЛЙ ÈßÁ ЛЙ ÈßÁ', 'ЛЙ'])]
    public function testPartCount (int $expected, string $string, string $search, ?Encoding $encoding = null):void {

        self::assertSame($expected, StrMB::partCount($string, $search, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([22, 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    public function testLength (int $expected, string $string, ?Encoding $encoding = null):void {

        self::assertSame($expected, StrMB::length($string, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int|false $expected
     * @param string $search
     * @param string $string
     * @param bool $case_sensitive
     * @param int $offset
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([false, 'лй', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith([11, 'лй', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false])]
    #[TestWith([11, 'ЛЙ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false, 9])]
    #[TestWith([0, 'đ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith([false, 'ЛЙ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false, 20])]
    public function testFirstPosition (int|false $expected, string $search, string $string, bool $case_sensitive = true, int $offset = 0, ?Encoding $encoding = null):void {

        self::assertSame($expected, StrMB::firstPosition($search, $string, $case_sensitive, $offset, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int|false $expected
     * @param string $search
     * @param string $string
     * @param bool $case_sensitive
     * @param int $offset
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([false, 'лй', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith([11, 'лй', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false])]
    #[TestWith([11, 'ЛЙ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false, 9])]
    #[TestWith([0, 'đ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith([false, 'ЛЙ', 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', false, 20])]
    public function testLastPosition (int|false $expected, string $search, string $string, bool $case_sensitive = true, int $offset = 0, ?Encoding $encoding = null):void {

        self::assertSame($expected, StrMB::lastPosition($search, $string, $case_sensitive, $offset, $encoding));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testListEncoding ():void {

        self::assertIsArray(StrMB::listEncodings());

        self::assertNotEmpty(StrMB::listEncodings());

    }

    /**
     * @since 1.0.0
     *
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError
     *
     * @return void
     */
    #[TestWith([Encoding::UTF_8])]
    public function testEncoding (?Encoding $encoding):void {

        self::assertTrue(StrMB::encoding($encoding));

        self::assertSame($encoding, StrMB::encoding());

    }

    /**
     * @since 1.0.0
     *
     * @param \FireHub\Core\Shared\Enums\String\Encoding $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith([Encoding::UTF_8, 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    public function testDetectEncoding (Encoding $expected, string $string):void {

        self::assertSame($expected, StrMB::detectEncoding($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param \FireHub\Core\Shared\Enums\String\Encoding $to
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $from
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\InvalidEncodingError
     *
     * @return void
     */
    #[TestWith([
        '+AREBYQENAQcBfg +i/ZncIJ+c5s +BBsEGQ +AMgA3wDB +MKswvzCrMMo-',
        'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ',
        Encoding::UTF_7
    ])]
    #[TestWith([
        '&AREBYQENAQcBfg- &i,ZncIJ+c5s- &BBsEGQ- &AMgA3wDB- &MKswvzCrMMo-',
        'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ',
        Encoding::UTF7_IMAP
    ])]
    public function testConvertEncoding (string $expected, string $string, Encoding $to, ?Encoding $from = null):void {

        self::assertSame(
            $expected,
            StrMB::convertEncoding($string, $to, $from)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $string
     * @param null|\FireHub\Core\Shared\Enums\String\Encoding $encoding
     *
     * @return void
     */
    #[TestWith([true, 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ'])]
    #[TestWith([false, 'đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ', Encoding::UTF_7])]
    public function testCheckEncoding (bool $expected, string $string, ?Encoding $encoding = null):void {

        self::assertSame($expected, StrMB::checkEncoding($string, $encoding));

    }

}