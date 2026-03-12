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
use FireHub\Core\Shared\Enums\DateTime\Zone;
use FireHub\Core\Throwable\Error\LowLevel\DateTime\ {
    ParseFromFormatError, StringToTimestampError
};
use FireHub\Core\Support\LowLevel\DateAndTime;
use FireHub\Tests\DataProviders\DateTimeDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, SmalL, TestWith
};

/**
 * ### Test low-level class for date and time inspection
 * @since 1.0.0
 */
#[Small]
#[Group('lowlevel')]
#[CoversClass(DateAndTime::class)]
final class DateAndTimeTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param int<1, 32767> $year
     * @param int<1, 12> $month
     * @param int<1, 31> $day
     *
     * @return void
     */
    #[DataProviderExternal(DateTimeDataProvider::class, 'validDates')]
    public function testCheckValid (int $year, int $month, int $day):void {

        self::assertTrue(DateAndTime::check($year, $month, $day));

    }

    /**
     * @since 1.0.0
     *
     * @param int<1, 32767> $year
     * @param int<1, 12> $month
     * @param int<1, 31> $day
     *
     * @return void
     */
    #[DataProviderExternal(DateTimeDataProvider::class, 'invalidDates')]
    public function testCheckInvalid (int $year, int $month, int $day):void {

        self::assertFalse(DateAndTime::check($year, $month, $day));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $datetime
     *
     * @return void
     */
    #[DataProviderExternal(DateTimeDataProvider::class, 'stringToTime')]
    public function testParse (string $datetime):void {

        self::assertEmpty(DateAndTime::parse($datetime)['errors']);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $format
     * @param non-empty-string $datetime
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\ParseFromFormatError
     *
     * @return void
     */
    #[TestWith(['j.n.Y H:iP', '6.1.2009 13:00+01:00'])]
    public function testParseFromFormat (string $format, string $datetime):void {

        self::assertEmpty(DateAndTime::parseFromFormat($format, $datetime)['errors']);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $format
     * @param non-empty-string $datetime
     *
     * @return void
     */
    #[TestWith(['Y', "\0"])]
    public function testParseFromFormatContainsNulByte (string $format, string $datetime):void {

        $this->expectException(ParseFromFormatError::class);

        DateAndTime::parseFromFormat($format, $datetime);

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $format
     * @param null|int $timestamp
     * @param bool $gmt
     *
     * @return void
     */
    #[TestWith(['1970-01-01T00:00:00+00:00', DATE_ATOM, 0, true])]
    #[TestWith(['Thursday, 01-Jan-1970 00:00:00 GMT', DATE_COOKIE, 0, true])]
    #[TestWith(['Thu, 01 Jan 1970 00:00:00 +0000', DATE_RSS, 0, true])]
    public function testFormat (string $expected, string $format, ?int $timestamp, bool $gmt):void {

        self::assertSame($expected, DateAndTime::format($format, $timestamp, $gmt));

    }

    /**
     * @since 1.0.0
     *
     * @param int $expected
     * @param string $format
     * @param null|int $timestamp
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\FailedToFormatTimestampAsIntError
     *
     * @return void
     */
    #[TestWith([70, 'y', 0])]
    #[TestWith([1970, 'Y', 0])]
    #[TestWith([1, 'd', 0])]
    #[TestWith([0, 'z', 0])]
    #[TestWith([1, 'W', 0])]
    #[TestWith([4, 'w', 0])]
    #[TestWith([0, 'U', 0])]
    #[TestWith([31, 't', 0])]
    #[TestWith([0, 's', 0])]
    #[TestWith([1, 'm', 0])]
    #[TestWith([0, 'i', 0])]
    public function testFormatInteger (int $expected, string $format, ?int $timestamp):void {

        self::assertSame($expected, DateAndTime::formatInteger($format, $timestamp));

    }

    /**
     * @since 1.0.0
     *
     * @param string $info
     * @param mixed $expected
     * @param null|int $timestamp
     *
     * @return void
     */
    #[TestWith(['seconds', 0, 0])]
    #[TestWith(['minutes', 0, 0])]
    #[TestWith(['mday', 1, 0])]
    #[TestWith(['wday', 4, 0])]
    #[TestWith(['mon', 1, 0])]
    #[TestWith(['year', 1970, 0])]
    #[TestWith(['yday', 0, 0])]
    #[TestWith(['weekday', 'Thursday', 0])]
    #[TestWith(['month', 'January', 0])]
    #[TestWith(['timestamp', 0, 0])]
    #[TestWith(['timestamp', 0, 0])]
    public function testGet (string $info, mixed $expected, ?int $timestamp):void {

        self::assertSame($expected, DateAndTime::get($timestamp)[$info]);

    }

    /**
     * @since 1.0.0
     *
     * @param int $timestamp
     * @param float $latitude
     * @param float $longitude
     *
     * @return void
     */
    #[TestWith([0, 40.730610, -73.935242])]
    public function testSunInfo (int $timestamp, float $latitude, float $longitude):void {

        $get = DateAndTime::sunInfo($timestamp, $latitude, $longitude);

        self::assertIsInt($get['sunrise']);
        self::assertIsInt($get['sunset']);
        self::assertIsInt($get['transit']);
        self::assertIsInt($get['civil_twilight_begin']);
        self::assertIsInt($get['civil_twilight_end']);
        self::assertIsInt($get['nautical_twilight_begin']);
        self::assertIsInt($get['nautical_twilight_end']);
        self::assertIsInt($get['astronomical_twilight_begin']);
        self::assertIsInt($get['astronomical_twilight_end']);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $datetime
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\StringToTimestampError
     *
     * @return void
     */
    #[DataProviderExternal(DateTimeDataProvider::class, 'stringToTime')]
    public function testStringToTimestamp (string $datetime):void {

        self::assertIsInt(DateAndTime::stringToTimestamp($datetime));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $datetime
     *
     * @return void
     */
    #[TestWith(['NotTime'])]
    public function testStringToTimestampNotTime (string $datetime):void {

        $this->expectException(StringToTimestampError::class);

        DateAndTime::stringToTimestamp($datetime);

    }

    /**
     * @since 1.0.0
     *
     * @param int<0, 24> $hour
     * @param null|int<0, 59> $minute
     * @param null|int<0, 59> $second
     * @param null|int $year
     * @param null|int<0, 12> $month
     * @param null|int<0, 31> $day
     * @param bool $gmt
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\FormatTimestampError
     *
     * @return void
     */
    #[TestWith([0, 0, 0, 1970, 1, 1])]
    #[TestWith([0, 0, 0, 1970, 1, 1, true])]
    public function testToTimestamp (int $hour, ?int $minute = null, ?int $second = null, ?int $year = null, ?int $month = null, ?int $day = null, bool $gmt = false):void {

        self::assertIsInt(DateAndTime::toTimestamp($hour, $minute, $second, $year, $month, $day, $gmt));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testTime ():void {

        self::assertIsInt(DateAndTime::time());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testMicrotime ():void {

        self::assertIsFloat(DateAndTime::microtime());

    }

    /**
     * @since 1.0.0
     *
     * @param \FireHub\Core\Shared\Enums\DateTime\Zone $expected
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\FailedToSetZoneError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\FailedToGetZoneError
     *
     * @return void
     */
    #[DataProviderExternal(DateTimeDataProvider::class, 'timezones')]
    public function testSetAndGetDefaultTimezone (Zone $expected):void {

        self::assertTrue(DateAndTime::setDefaultTimezone($expected));
        self::assertSame($expected, DateAndTime::getDefaultTimezone());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testAbbreviationList ():void {

        self::assertIsArray(DateAndTime::abbreviationList());

    }

}