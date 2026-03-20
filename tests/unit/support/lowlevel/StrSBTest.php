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
use FireHub\Core\Shared\Enums\String\Count\ {
    CharacterMode, WordFormat
};
use FireHub\Core\Throwable\Error\LowLevel\String\ {
    ChunkLengthLessThanOneError, ComparePartError, EmptyPadError, EmptySeparatorError
};
use FireHub\Core\Support\LowLevel\StrSB;
use FireHub\Tests\DataProviders\StrDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Depends, Group, Small, TestWith
};

/**
 * ### Test Single-byte string low-level proxy class
 * @since 1.0.0
 */
#[Small]
#[Group('lowlevel')]
#[CoversClass(StrSB::class)]
final class StrSBTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $value
     * @param string $string
     *
     * @return void
     */
    #[TestWith([false, 'j', ''])]
    #[TestWith([true, 'j', 'ijk'])]
    public function testContains (bool $expected, string $value, string $string):void {

        self::assertSame($expected, StrSB::contains($value, $string));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $value
     * @param string $string
     *
     * @return void
     */
    #[TestWith([false, 'j', ''])]
    #[TestWith([true, 'i', 'ijk'])]
    public function testStartsWith (bool $expected, string $value, string $string):void {

        self::assertSame($expected, StrSB::startsWith($value, $string));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $value
     * @param string $string
     *
     * @return void
     */
    #[TestWith([false, 'j', ''])]
    #[TestWith([true, 'k', 'ijk'])]
    public function testEndsWith (bool $expected, string $value, string $string):void {

        self::assertSame($expected, StrSB::endsWith($value, $string));

    }


    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(["O\\\\\\'Reilly", "O\'Reilly"])]
    #[TestWith(["O\'Reilly", "O'Reilly"])]
    #[TestWith(["O\\\\\\\"Reilly", 'O\"Reilly'])]
    #[TestWith(["O\\\\\\\"Reilly", 'O\"Reilly'])]
    #[TestWith(["O\\\\Reilly", 'O\\Reilly'])]
    #[TestWith(["O\\\\Reilly", 'O\Reilly'])]
    public function testAddStripSlashes (string $expected, string $string):void {

        self::assertSame($expected, StrSB::addSlashes($string));
        self::assertSame($string, StrSB::stripSlashes($expected));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param null|string $characters
     *
     * @return void
     */
    #[TestWith(["\\O\\\\Reilly", 'O\Reilly', 'A..Z'])]
    #[TestWith(["OR\\e\\i\\l\\l\\y", 'OReilly', 'a..z'])]
    public function testAddCStripSlashes (string $expected, string $string, ?string $characters = null):void {

        self::assertSame($expected, StrSB::addCSlashes($string, $characters));
        self::assertSame($string, StrSB::stripCSlashes($expected));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param array<array-key, null|scalar|\Stringable> $array
     * @param string $separator
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\EmptySeparatorError
     *
     * @return void
     */
    #[TestWith([' ', ['', ''], ' '])]
    #[TestWith(['The lazy fox jumped over the fence', ['The', 'lazy', 'fox', 'jumped', 'over', 'the', 'fence'], ' '])]
    #[TestWith(['The lazy fox - over the fence', ['The lazy fox ', ' over the fence'], '-'])]
    public function testImplodeExplode (string $expected, array $array, string $separator = ''):void {

        self::assertSame($expected, StrSB::implode($array, $separator));
        self::assertSame($array, StrSB::explode($expected, $separator));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param string $separator
     *
     * @return void
     */
    #[TestWith(['The lazy fox jumped over the fence', ''])]
    public function testExplodeEmptyString (string $string, string $separator):void {

        $this->expectException(EmptySeparatorError::class);

        StrSB::explode($string, $separator);

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith([
        "PHP is a popular scripting language\. Fast, flexible, and pragmatic\.",
        'PHP is a popular scripting language. Fast, flexible, and pragmatic.'
    ])]
    public function testQuoteMeta (string $expected, string $string):void {

        self::assertSame($expected, StrSB::quoteMeta($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param int $times
     * @param string $separator
     *
     * @return void
     */
    #[TestWith(['fox-fox', 'fox', 2, '-'])]
    public function testRepeat (string $expected, string $string, int $times, string $separator = ''):void {

        self::assertSame($expected, StrSB::repeat($string, $times, $separator));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param null|string|array<int, string> $allowed_tags
     *
     * @return void
     */
    #[TestWith([
        'Test paragraph. Other text',
        '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>'
    ])]
    #[TestWith([
        '<p>Test paragraph.</p> <a href="#fragment">Other text</a>',
        '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>',
        ['p', 'a']
    ])]
    public function testStripTags (string $expected, string $string, null|string|array $allowed_tags = null):void {

        self::assertSame($expected, StrSB::stripTags($string, $allowed_tags));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param positive-int $length
     * @param string $separator
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\ChunkLengthLessThanOneError
     *
     * @return void
     */
    #[TestWith([
        'The lazy f-ox jumped -over the f-ence-',
        'The lazy fox jumped over the fence',
        10,
        '-'
    ])]
    public function testChunkSplit (string $expected, string $string, int $length = 76, string $separator = "\r\n"):void {

        self::assertSame($expected, StrSB::chunkSplit($string, $length, $separator));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param positive-int $length
     * @param string $separator
     *
     * @return void
     */
    #[TestWith(['The lazy fox jumped over the fence', 0, '-'])]
    public function testChunkSplitLengthLessThanOne (string $string, int $length = 76, string $separator = "\r\n"):void {

        $this->expectException(ChunkLengthLessThanOneError::class);

        StrSB::chunkSplit($string, $length, $separator);

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param int $length
     * @param non-empty-string $pad
     * @param \FireHub\Core\Shared\Enums\Side $side
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\EmptyPadError
     *
     * @return void
     */
    #[TestWith([
        '----------------The lazy fox jumped over the fence',
        'The lazy fox jumped over the fence',
        50,
        '-',
        Side::LEFT
    ])]
    #[TestWith([
        'The lazy fox jumped over the fence----------------',
        'The lazy fox jumped over the fence',
        50,
        '-'
    ])]
    #[TestWith([
        '--------The lazy fox jumped over the fence--------',
        'The lazy fox jumped over the fence',
        50,
        '-',
        Side::BOTH
    ])]
    public function testPad (string $expected, string $string, int $length, string $pad = " ", Side $side = Side::RIGHT):void {

        self::assertSame($expected, StrSB::pad($string, $length, $pad, $side));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     * @param int $length
     * @param non-empty-string $pad
     * @param \FireHub\Core\Shared\Enums\Side $side
     *
     * @return void
     */
    #[TestWith([
        'The lazy fox jumped over the fence',
        50,
        '',
        Side::BOTH
    ])]
    public function testPadIsEmpty (string $string, int $length, string $pad = " ", Side $side = Side::RIGHT):void {

        $this->expectException(EmptyPadError::class);

        StrSB::pad($string, $length, $pad, $side);

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string|list<string> $search
     * @param string|list<string> $replace
     * @param string $string
     * @param bool $case_sensitive
     * @param int $count_replaced
     *
     * @return void
     */
    #[TestWith([
        'The lazy mouse jumped over the fence',
        'fox',
        'mouse',
        'The lazy fox jumped over the fence',
        true,
        1
    ])]
    #[TestWith([
        'The lazy fox jumped over the fence',
        'Fox',
        'mouse',
        'The lazy fox jumped over the fence',
        true,
        0
    ])]
    #[TestWith([
        'The lazy fox, the lazy fox, the lazy fox',
        'mouse',
        'fox',
        'The lazy mouse, the lazy mouse, the lazy mouse',
        true,
        3
    ])]
    #[TestWith([
        'The lazy mouse jumped over the fence',
        'Fox',
        'mouse',
        'The lazy fox jumped over the fence',
        false,
        1
    ])]
    #[TestWith([
        'An lazy mouse jumped over the fence',
        ['The', 'fox'],
        ['An',  'mouse'],
        'The lazy fox jumped over the fence',
        true,
        2
    ])]
    public function testReplace (string $expected, string|array $search, string|array $replace, string $string, bool $case_sensitive, int $count_replaced):void {

        self::assertSame($expected, StrSB::replace($search, $replace, $string, $case_sensitive, $count));
        self::assertSame($count, $count_replaced);

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param string $replace
     * @param int $offset
     * @param null|int $length
     *
     * @return void
     */
    #[TestWith([
        'An lazy fox jumped over the fence',
        'The lazy fox jumped over the fence',
        'An',
        0,
        3
    ])]
    #[TestWith([
        'The lazy fox jumped over the bush',
        'The lazy fox jumped over the fence',
        'bush',
        -5,
        5
    ])]
    public function testReplacePart (string $expected, string $string, string $replace, int $offset, ?int $length = null):void {

        self::assertSame($expected, StrSB::replacePart($string, $replace, $offset, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string
     *
     * @return void
     */
    #[Depends('testLength')]
    #[Depends('testSplit')]
    #[DataProviderExternal(StrDataProvider::class, 'stringsSB')]
    public function testShuffle (string $string):void {

        $shuffled = StrSB::shuffle($string);

        self::assertSame(StrSB::length($string), StrSB::length($shuffled));

        self::assertEqualsCanonicalizing(StrSB::split($string), StrSB::split($shuffled));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['ecnef eht revo depmuj xof yzal ehT', 'The lazy fox jumped over the fence'])]
    public function testReverse (string $expected, string $string):void {

        self::assertSame($expected, StrSB::reverse($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param int $width
     * @param string $break
     * @param bool $cut_long_words
     *
     * @return void
     */
    #[TestWith(['The lazy fox jumped<br />over the fence', 'The lazy fox jumped over the fence', 20, '<br />', true])]
    #[TestWith(['A very<br />long<br />wooooooo<br />ooooord', 'A very long woooooooooooord', 8, '<br />', true])]
    public function testWrap (string $expected, string $string, int $width = 75, string $break = "\n", bool $cut_long_words = false):void {

        self::assertSame($expected, StrSB::wrap($string, $width, $break, $cut_long_words));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param \FireHub\Core\Shared\Enums\Side $side
     * @param string $characters
     *
     * @return void
     */
    #[TestWith([
        "These are a few words :) ...  \n\r",
        "\t\tThese are a few words :) ...  \n\r",
        Side::LEFT
    ])]
    #[TestWith([
        "\t\tThese are a few words :) ...",
        "\t\tThese are a few words :) ...",
        Side::RIGHT
    ])]
    #[TestWith([
        "These are a few words :) ...",
        "\t\tThese are a few words :) ...  \n\r"
    ])]
    public function testTrim (string $expected, string $string, Side $side = Side::BOTH, string $characters = " \n\r\t\v\x00"):void {

        self::assertSame($expected, StrSB::trim($string, $side, $characters));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['the lazy fox jumped over the fence', 'The lazy fox jumped over the fence'])]
    public function testToLower (string $expected, string $string):void {

        self::assertSame($expected, StrSB::toLower($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['THE LAZY FOX JUMPED OVER THE FENCE', 'The lazy fox jumped over the fence'])]
    public function testToUpper (string $expected, string $string):void {

        self::assertSame($expected, StrSB::toUpper($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['The Lazy Fox Jumped Over The Fence', 'The lazy fox jumped over the fence'])]
    public function testToTitle (string $expected, string $string):void {

        self::assertSame($expected, StrSB::toTitle($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['The lazy fox jumped over the fence', 'the lazy fox jumped over the fence'])]
    public function testCapitalize (string $expected, string $string):void {

        self::assertSame($expected, StrSB::capitalize($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['the lazy fox jumped over the fence', 'The lazy fox jumped over the fence'])]
    public function testDeCapitalize (string $expected, string $string):void {

        self::assertSame($expected, StrSB::deCapitalize($string));

    }

    /**
     * @since 1.0.0
     *
     * @param int<-1, 1> $expected
     * @param string $string_1
     * @param string $string_2
     * @param bool $case_sensitive
     *
     * @return void
     */
    #[TestWith([-1, 'a', 'z'])]
    #[TestWith([1, 'hello', 'Hello'])]
    #[TestWith([0, 'Hello', 'Hello'])]
    #[TestWith([1, 'a', 'A'])]
    #[TestWith([0, 'a', 'A', false])]
    public function testCompare (int $expected, string $string_1, string $string_2, bool $case_sensitive = true):void {

        self::assertSame($expected, StrSB::compare($string_1, $string_2, $case_sensitive));

    }

    /**
     * @since 1.0.0
     *
     * @param int<-1, 1> $expected
     * @param string $string_1
     * @param string $string_2
     * @param int $offset
     * @param null|int $length
     * @param bool $case_sensitive
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\String\ComparePartError
     *
     * @return void
     */
    #[TestWith([0, 'abcde', 'BC', 1, 2, false])]
    #[TestWith([1, 'abcde', 'BC', 1, 3])]
    #[TestWith([-1, 'abcde', 'cd', 1, 2])]
    public function testComparePart (int $expected, string $string_1, string $string_2, int $offset, ?int $length = null, bool $case_sensitive = true):void {

        self::assertSame($expected, StrSB::comparePart($string_1, $string_2, $offset, $length, $case_sensitive));

    }

    /**
     * @since 1.0.0
     *
     * @param string $string_1
     * @param string $string_2
     * @param int $offset
     * @param null|int $length
     * @param bool $case_sensitive
     *
     * @return void
     */
    #[TestWith(['abcde', 'BC', 10])]
    public function testComparePartOffsetHigherThenString (string $string_1, string $string_2, int $offset, ?int $length = null, bool $case_sensitive = true):void {

        $this->expectException(ComparePartError::class);

        StrSB::comparePart($string_1, $string_2, $offset, $length, $case_sensitive);

    }

    /**
     * @since 1.0.0
     *
     * @param int<-1, 1> $expected
     * @param string $string_1
     * @param string $string_2
     * @param int $length
     *
     * @return void
     */
    #[TestWith([1, 'Hello John', 'Hello Doe', 50])]
    #[TestWith([0, 'Hello John', 'Hello Doe', 5])]
    public function testCompareFirstN (int $expected, string $string_1, string $string_2, int $length):void {

        self::assertSame($expected, StrSB::compareFirstN($string_1, $string_2, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int|false $expected
     * @param string $search
     * @param string $string
     * @param bool $case_sensitive
     * @param int $offset
     *
     * @return void
     */
    #[TestWith([false, 'Fox', 'The lazy fox jumped over the fence'])]
    #[TestWith([9, 'Fox', 'The lazy fox jumped over the fence', false])]
    #[TestWith([9, 'Fox', 'The lazy fox jumped over the fence', false, 9])]
    #[TestWith([0, 'T', 'The lazy fox jumped over the fence'])]
    #[TestWith([false, 'Fox', 'The lazy fox jumped over the fence', false, 10])]
    public function testFirstPosition (int|false $expected, string $search, string $string, bool $case_sensitive = true, int $offset = 0):void {

        self::assertSame($expected, StrSB::firstPosition($search, $string, $case_sensitive, $offset));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int|false $expected
     * @param string $search
     * @param string $string
     * @param bool $case_sensitive
     * @param int $offset
     *
     * @return void
     */
    #[TestWith([false, 'Fox', 'The lazy fox jumped over the fence'])]
    #[TestWith([9, 'Fox', 'The lazy fox jumped over the fence', false])]
    #[TestWith([9, 'Fox', 'The lazy fox jumped over the fence', false, 9])]
    #[TestWith([0, 'T', 'The lazy fox jumped over the fence'])]
    #[TestWith([false, 'Fox', 'The lazy fox jumped over the fence', false, 10])]
    public function testLastPosition (int|false $expected, string $search, string $string, bool $case_sensitive = true, int $offset = 0):void {

        self::assertSame($expected, StrSB::lastPosition($search, $string, $case_sensitive, $offset));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param array<non-empty-string, string> $replace_pairs
     *
     * @return void
     */
    #[TestWith(['Hello World', 'Hillo Warld', ['il' => 'el', 'ar' => 'or']])]
    public function testTranslate (string $expected, string $string, array $replace_pairs):void {

        self::assertSame($expected, StrSB::translate($string, $replace_pairs));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param int $start
     * @param null|int $length
     *
     * @return void
     */
    #[TestWith(['azy fox jumped over the fence', 'The lazy fox jumped over the fence', 5])]
    #[TestWith(['ox j', 'The lazy fox jumped over the fence', 10, 4])]
    #[TestWith(['fen', 'The lazy fox jumped over the fence', -5, 3])]
    public function testPart (string $expected, string $string, int $start, ?int $length = null):void {

        self::assertSame($expected, StrSB::part($string, $start, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $find
     * @param string $string
     * @param bool $before_needle
     * @param bool $case_sensitive
     *
     * @return void
     */
    #[TestWith(['fox jumped over the fence', 'fox', 'The lazy fox jumped over the fence'])]
    #[TestWith(['The lazy', ' fox', 'The lazy fox jumped over the fence', true])]
    #[TestWith([' fox jumped over the fence', ' Fox', 'The lazy fox jumped over the fence', false, false])]
    public function testFirstOccurrence (string $expected, string $find, string $string, bool $before_needle = false, bool $case_sensitive = true):void {

        self::assertSame($expected, StrSB::firstOccurrence($find, $string, $before_needle, $case_sensitive));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $string
     * @param string $find
     * @param bool $before_needle
     *
     * @return void
     */
    #[TestWith(['jumped over the fence', 'jumped', 'The lazy fox jumped over the fence'])]
    public function testLastCharacterFrom (string $expected, string $find, string $string, bool $before_needle = false):void {

        self::assertSame($expected, StrSB::lastCharacterFrom($find, $string, $before_needle));

    }

    /**
     * @since 1.0.0
     *
     * @param string|false $expected
     * @param string $characters
     * @param string $string
     *
     * @return void
     */
    #[TestWith(['ox jumped over the fence', 'xov', 'The lazy fox jumped over the fence'])]
    #[TestWith([false, 'bqg', 'The lazy fox jumped over the fence'])]
    public function testPartFrom (string|false $expected, string $characters, string $string):void {

        self::assertSame($expected, StrSB::partFrom($characters, $string));

    }

    /**
     * @since 1.0.0
     *
     * @param array<int, int> $expected
     * @param string $string
     * @param \FireHub\Core\Shared\Enums\String\Count\CharacterMode $mode
     *
     * @return void
     */
    #[TestWith([
        [
            32 => 6, 84 => 1, 97 => 1, 99 => 1, 100 => 1, 101 => 6, 102 => 2,
            104 => 2, 106 => 1, 108 => 1, 109 => 1, 110 => 1, 111 =>  2, 112 => 1,
            114 => 1, 116 => 1, 117 => 1, 118 => 1, 120 => 1, 121 => 1, 122 =>  1
        ],
        'The lazy fox jumped over the fence'
    ])]
    public function testCountByChar (array $expected, string $string, CharacterMode $mode = CharacterMode::ARR_POSITIVE):void {

        self::assertSame($expected, StrSB::countByChar($string, $mode));

    }

    /**
     * @since 1.0.0
     *
     * @param int|array<int, string> $expected
     * @param non-empty-string $string
     * @param null|string $characters
     * @param \FireHub\Core\Shared\Enums\String\Count\WordFormat $format
     *
     * @return void
     */
    #[TestWith([
        7,
        'The lazy fox jumped3over the fence'
    ])]
    #[TestWith([
        6,
        'The lazy fox jumped3over the fence',
        'jumped3over'
    ])]
    #[TestWith([
        [
            0 => 'The',
            1 => 'lazy',
            2 => 'fox',
            3 => 'jumped',
            4 => 'over',
            5 => 'the',
            6 => 'fence'
        ],
        'The lazy fox jumped over the fence',
        null,
        WordFormat::ARR_WORDS
    ])]
    #[TestWith([
        [
            0 => 'The',
            4 => 'lazy',
            9 => 'fox',
            13 => 'jumped',
            20 => 'over',
            25 => 'the',
            29 => 'fence'
        ],
        'The lazy fox jumped over the fence',
        null,
        WordFormat::ASSOC_ARR_WORDS
    ])]
    public function testCountWords (int|array $expected, string $string, ?string $characters = null, WordFormat $format = WordFormat::WORDS):void {

        self::assertSame($expected, StrSB::countWords($string, $characters, $format));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     * @param string $search
     * @param int $start
     * @param null|int $length
     *
     * @return void
     */
    #[TestWith([2, 'This is a test', 'is'])]
    #[TestWith([1, 'This is a test', 'is', 3])]
    #[TestWith([0, 'This is a test', 'is', 3, 3])]
    public function testPartCount (int $expected, string $string, string $search, int $start = 0, ?int $length = null):void {

        self::assertSame($expected, StrSB::partCount($string, $search, $start, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     * @param string $characters
     * @param int $offset
     * @param null|int $length
     *
     * @return void
     */
    #[TestWith([0, 'The lazy fox jumped over the fence', 'lazy'])]
    #[TestWith([4, 'The lazy fox jumped over the fence', 'lazy',4])]
    #[TestWith([3, 'The lazy fox jumped over the fence', 'lazy',4, 3])]
    public function testSegmentMatching (int $expected, string $string, string $characters, int $offset = 0, ?int $length = null):void {

        self::assertSame($expected, StrSB::segmentMatching($string, $characters, $offset, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     * @param string $characters
     * @param int $offset
     * @param null|int $length
     *
     * @return void
     */
    #[TestWith([4, 'The lazy fox jumped over the fence', 'lazy', 0])]
    #[TestWith([0, 'The lazy fox jumped over the fence', 'lazy', 4])]
    #[TestWith([2, 'The lazy fox jumped over the fence', 'lazy', 2, 4])]
    public function testSegmentNotMatching (int $expected, string $string, string $characters, int $offset = 0, ?int $length = null):void {

        self::assertSame($expected, StrSB::segmentNotMatching($string, $characters, $offset, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $string
     *
     * @return void
     */
    #[TestWith([34, 'The lazy fox jumped over the fence'])]
    #[TestWith([0, ''])]
    public function testLength (int $expected, string $string):void {

        self::assertSame($expected, StrSB::length($string));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $format
     * @param null|scalar...$values
     *
     * @return void
     */
    #[TestWith(['There are 5 monkeys in the tree', 'There are %d monkeys in the %s', 5, 'tree'])]
    public function testFormat (string $expected, string $format, null|bool|float|int|string ...$values):void {

        self::assertSame($expected, StrSB::format($format, ...$values));

    }

}