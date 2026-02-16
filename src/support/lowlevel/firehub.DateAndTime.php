<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.0
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;
use FireHub\Core\Shared\Enums\DateTime\Zone;
use FireHub\Core\Throwable\Error\LowLevel\DateTime\ {
    FailedToFormatTimestampAsIntError, FailedToGetZoneError, FailedToSetZoneError, FormatTimestampError,
    ParseFromFormatError, StringToTimestampError
};
use ValueError;

use function checkdate;
use function date_default_timezone_get;
use function date_default_timezone_set;
use function date;
use function date_parse;
use function date_parse_from_format;
use function date_sun_info;
use function getdate;
use function gmdate;
use function gmmktime;
use function idate;
use function localtime;
use function microtime;
use function mktime;
use function time;
use function timezone_abbreviations_list;

/**
 * ### Low-level class for date and time inspection
 *
 * Provides static methods to inspect and interact with PHP date and time structures, including DateTime objects,
 * timestamps, intervals, and timezone information.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class DateAndTime extends LowLevel {

    /**
     * ### Check for a valid date
     *
     * Checks the validity of the date formed by the arguments.<br>
     * A date is considered valid if each parameter is properly defined.
     * @since 1.0.0
     *
     * @param int<1, 32767> $year <p>
     * The year is between 1 and 32,767 inclusive.
     * </p>
     * @param int<1, 12> $month <p>
     * The month is between 1 and 12 inclusive.
     * </p>
     * @param int<1, 31> $day <p>
     * The day is within the allowed number of days for the given month.<br>
     * Leap years are taken into consideration.
     * </p>
     *
     * @return bool True, if the date given is valid, otherwise returns false.
     */
    public static function check (int $year, int $month, int $day):bool {

        return checkdate($month, $day, $year);

    }

    /**
     * ### Returns associative array with detailed info about the given date/time
     *
     * Method parses the given datetime string according to the same rules as DateAndTime#stringToTimestamp().
     * @since 1.0.0
     *
     * @param non-empty-string $datetime <p>
     * String representing the date/time.
     * </p>
     *
     * @return array<string, mixed> Associative array with detailed info about the given date/time.
     *
     * @warning The number of array elements in the warning and errors arrays might be lower than warning_count or
     * error_count if they occurred at the same position.
     */
    public static function parse (string $datetime):array {

        return date_parse($datetime);

    }

    /**
     * ### Get info about the given date formatted according to the specified format
     * @since 1.0.0
     *
     * @param non-empty-string $format <p>
     * Format accepted by date with some extras.
     * </p>
     * @param non-empty-string $datetime <p>
     * String representing the date/time.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\ParseFromFormatError If $datetime contains NULL-bytes.
     *
     * @return array{
     *  year: int|false, month: int|false, day: int|false, hour: int|false, minute: int|false, second: int|false,
     *  fraction: float|false, warning_count: int, warnings: array<string>, error_count: int, errors: array<string>,
     *  is_localtime: bool, zone_type?: bool|int, zone?: bool|int, is_dst?: bool, tz_abbr?: string, tz_id?: string,
     *  relative?: array{
     *   year: int, month: int, day: int, hour: int, minute: int, second: int, weekday?: int, weekdays?: int,
     *   first_day_of_month?: bool, last_day_of_month?: bool
     *  }
     * } Associative array with detailed info about a given date/time.
     *
     * @warning The number of array elements in the warning and errors arrays might be lower than warning_count or
     * error_count if they occurred at the same position-
     */
    public static function parseFromFormat (string $format, string $datetime):array {

        try {

            return date_parse_from_format($format, $datetime);

        } catch (ValueError) {

            throw new ParseFromFormatError('$datetime contains NULL-bytes');

        }

    }

    /**
     * ### Format a Unix timestamp
     *
     * Returns a string formatted according to the given format string using the given integer timestamp (Unix
     * timestamp) or the current time if no timestamp is given.<br>
     * In other words, timestamp is optional and defaults to the value of DateAndTime#time().
     * @since 1.0.0
     *
     * @link https://www.php.net/manual/en/datetime.format.php To check valid $format formats.
     *
     * @param string $format [optional] <p>
     * The format of the outputted date string.
     * </p>
     * @param null|int $timestamp [optional] <p>
     * The optional timestamp parameter is an integer Unix timestamp that defaults to the current local time if a
     * timestamp is not given.
     * </p>
     * @param bool $gmt [optional] <p>
     * Format a GMT/UTC date/time.
     * </p>
     *
     * @return string String formatted according to the given format string using the given integer timestamp.
     */
    public static function format (string $format = 'Y-m-d H:i:s.u', ?int $timestamp = null, bool $gmt = false):string {

        return $gmt ? gmdate($format, $timestamp) : date($format, $timestamp);

    }

    /**
     * ### Format a Unix timestamp as integer
     *
     * Returns a formatted number, according to the given format string using the given integer timestamp or the current
     * local time, if no timestamp is given.<br>
     * In other words, timestamp is optional and defaults to the value of DateAndTime#time().
     * @since 1.0.0
     *
     * @link https://www.php.net/manual/en/function.idate.php
     *
     * @param 'B'|'d'|'h'|'H'|'i'|'I'|'L'|'m'|'s'|'t'|'U'|'w'|'W'|'y'|'Y'|'z'|'Z' $format <p>
     * Single format character.
     * </p>
     * @param null|int $timestamp [optional] <p>
     * The optional timestamp parameter is an integer Unix timestamp that defaults to the current local time if a
     * timestamp is not given.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\FailedToFormatTimestampAsIntError If failed to format
     * a Unix timestamp as integer.
     *
     * @return int Formatted date as an integer.
     */
    public static function formatInteger (string $format, ?int $timestamp = null):int {

        return ($i_date = idate($format, $timestamp)) !== false
            ? $i_date
            : throw new FailedToFormatTimestampAsIntError;

    }

    /**
     * ### Get date/time information
     * @since 1.0.0
     *
     * @param null|int $timestamp [optional] <p>
     * The optional timestamp parameter is an int Unix timestamp that defaults to the current local time if
     * the timestamp is omitted or null.
     * </p>
     *
     * @return array{
     *   seconds: int<0, 59>,
     *   minutes: int<0, 59>,
     *   hours: int<0, 23>,
     *   mday: int<1, 31>,
     *   wday: int<0, 6>,
     *   mon: int<1, 12>,
     *   year: int,
     *   yday: int<0, 365>,
     *   weekday: 'Friday'|'Monday'|'Saturday'|'Sunday'|'Thursday'|'Tuesday'|'Wednesday',
     *   month: 'April'|'August'|'December'|'February'|'January'|'July'|'June'|'March'|'May'|'November'|'October'|'September',
     *   timestamp: int,
     *   dts: 0|1
     * } Associative array of information related to the timestamp.
     */
    public static function get (?int $timestamp = null):array {

        $get_date = ($get_date = getdate($timestamp)) + [
            'timestamp' => $get_date[0],
            'dts' => localtime($timestamp, true)['tm_isdst'] ?? 0
        ];

        unset($get_date[0]);

        /** @var array{
         *   seconds: int<0, 59>,
         *   minutes: int<0, 59>,
         *   hours: int<0, 23>,
         *   mday: int<1, 31>,
         *   wday: int<0, 6>,
         *   mon: int<1, 12>,
         *   year: int,
         *   yday: int<0, 365>,
         *   weekday: 'Friday'|'Monday'|'Saturday'|'Sunday'|'Thursday'|'Tuesday'|'Wednesday',
         *   month: 'April'|'August'|'December'|'February'|'January'|'July'|'June'|'March'|'May'|'November'|'October'|'September',
         *   timestamp: int,
         *   dts: 0|1
         * }
         */
        return $get_date;

    }

    /**
     * ### Gets information about sunset/sunrise and twilight begin/end
     * @since 1.0.0
     *
     * @param int $timestamp <p>
     * Unix timestamp.
     * </p>
     * @param float $latitude <p>
     * Latitude in degrees.
     * </p>
     * @param float $longitude <p>
     * Longitude in degrees.
     * </p>
     *
     * @return array{
     *   sunrise: int|bool,
     *   sunset: int|bool,
     *   transit: int|bool,
     *   civil_twilight_begin: int|bool,
     *   civil_twilight_end: int|bool,
     *   nautical_twilight_begin: int|bool,
     *   nautical_twilight_end: int|bool,
     *   astronomical_twilight_begin: int|bool,
     *   astronomical_twilight_end: int|bool
     * } Array with sunset and twilight details.
     */
    public static function sunInfo (int $timestamp, float $latitude, float $longitude):array {

        return date_sun_info($timestamp, $latitude, $longitude);

    }

    /**
     * ### Parse about any English textual datetime description into a Unix timestamp
     *
     * The method expects to be given a string containing an English date format and will try to parse that format
     * into a Unix timestamp (the number of seconds since January 1, 1970 00:00:00 UTC), relative to the timestamp
     * given in baseTimestamp, or the current time if baseTimestamp is not supplied.
     * @since 1.0.0
     *
     * @link https://www.php.net/manual/en/datetime.formats.php To check how to pass $datetime parameter.
     *
     * @param non-empty-string $datetime <p>
     * A date/time string.
     * </p>
     * @param null|int $timestamp [optional] <p>
     * The timestamp which is used as a base for the calculation of relative dates.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\StringToTimestampError If we couldn't convert string
     * to timestamp.
     *
     * @return int A timestamp.
     *
     * @note If the number of the year is specified in a two-digit format, the values between 00-69 are mapped to
     * 2000-2069 and 70-99 to 1970-1999.<br>
     * See the notes below for possible differences on 32bit systems (possible dates might end on 2038-01-19 03:14:07).
     * @note The valid range of a timestamp is typically from Fri, 13 Dec 1901 20:45:54 UTC to Tue, 19 Jan 2038
     * 03:14:07 UTC (These are the dates that correspond to the minimum and maximum values for a 32-bit signed
     * integer.).<br>
     * For 64-bit versions of PHP, the valid range of a timestamp is effectively infinite, as 64 bits can represent
     * approximately 293 billion years in either direction.
     */
    public static function stringToTimestamp (string $datetime, ?int $timestamp = null):int {

        return ($str_to_time = strtotime($datetime, $timestamp)) !== false
            ? $str_to_time : throw new StringToTimestampError;

    }

    /**
     * ### Format a Unix timestamp
     *
     * Returns the Unix timestamp corresponding to the arguments given.<br>
     * This timestamp is a long integer containing the number of seconds between the Unix Epoch (January, 1 1970
     * 00:00:00 GMT) and the time specified.
     * @since 1.0.0
     *
     * @param int<0, 24> $hour <p>
     * The number of hours relative to the start of the day is determined by month, day, and year.
     * Negative values reference the hour before midnight of the day in question.
     * Values greater than 23 reference the appropriate hour on the following day(s).
     * </p>
     * @param null|int<0, 59> $minute [optional] <p>
     * The number of the minutes relative to the start of the hour.<br>
     * Negative values reference the minute in the previous hour.<br>
     * Values greater than reference 59 the appropriate minute in the following hour(s).
     * </p>
     * @param null|int<0, 59> $second [optional] <p>
     * The number of seconds relative to the start of the minute.<br>
     * Negative values reference the second in the previous minute.<br>
     * Values greater than 59 reference the appropriate second in the following minute(s).
     * </p>
     * @param null|int $year [optional] <p>
     * The year.
     * </p>
     * @param null|int<0, 12> $month [optional] <p>
     * The number of the month relative to the end of the previous year.<br>
     * Values 1 to 12 reference the normal calendar months of the year in question.<br>
     * Values less than 1 (including negative values) reference the months in the previous year in reverse order, so
     * 0 is December, -1 is November, and so on.<br>
     * Values greater than 12 reference the appropriate month in the following year(s).
     * </p>
     * @param null|int<0, 31> $day [optional] <p>
     * The number of the days relative to the end of the previous month.<br>
     * Values 1 to 28, 29, 30, or 31 (depending upon the month) reference the normal days in the relevant month.<br>
     * Values less than 1 (including negative values) reference the days in the previous month, so 0 is the last day
     * of the previous month, -1 is the day before that, and so on.<br>
     * Values greater than the number of days in the relevant month reference the appropriate day in the following
     * month(s).
     * </p>
     * @param bool $gmt [optional] <p>
     * Get a GMT/UTC timestamp.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\FormatTimestampError If the timestamp doesn't fit in a
     * PHP integer.
     *
     * @return int The Unix timestamp of the arguments given.
     */
    public static function toTimestamp (int $hour, ?int $minute = null, ?int $second = null, ?int $year = null, ?int $month = null, ?int $day = null, bool $gmt = false):int {

        return (
        $timestamp = $gmt
            ? gmmktime($hour, $minute, $second, $month, $day, $year)
            : mktime($hour, $minute, $second, $month, $day, $year)
        ) !== false ? $timestamp : throw new FormatTimestampError;

    }

    /**
     * ### Return current Unix timestamp
     *
     * Returns the current time measured in the number of seconds since the Unix Epoch (January, 1 1970 00:00:00 GMT).
     * @since 1.0.0
     *
     * @return positive-int The current timestamp.
     *
     * @tip The timestamp of the start for the request is available in $_SERVER['REQUEST_TIME'].
     */
    public static function time ():int {

        return time();

    }

    /**
     * ### Get current Unix microseconds
     *
     * Method returns the current Unix timestamp with microseconds.<br>
     * This function is only available on operating systems that support the gettimeofday() system call.
     * @since 1.0.0
     *
     * @return float The current timestamp with microseconds.
     *
     * @tip For performance measurements, using hrtime() is recommended.
     */
    public static function microtime ():float {

        return microtime(true);

    }

    /**
     * ### Gets the default timezone used by all date/time functions in a script
     *
     * In order of preference, this function returns the default timezone by:
     * - reading the timezone set using the setDefaultTimezone() method (if any).
     * - reading the value of the 'date.timezone' ini option (if set).
     * If none of the above succeeds, DateAndTimeZone#getDefaultTimezone() will return a default timezone of UTC.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\DateTime\Zone To check for a valid timezone.
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\FailedToGetZoneError If we can't get the default
     * timezone.
     *
     * @return \FireHub\Core\Shared\Enums\DateTime\Zone Timezone enum.
     */
    public static function getDefaultTimezone ():Zone {

        return Zone::tryFrom(date_default_timezone_get())
            ?? throw new FailedToGetZoneError;

    }

    /**
     * ### Sets the default timezone used by all date/time functions in a script
     *
     * Method sets the default timezone used by all date/time functions.<br>
     * Instead of using this function to set the default timezone in your script, you can also use the INI setting
     * 'date.timezone' to set the default timezone.
     * @since 1.0.0
     *
     * @param \FireHub\Core\Shared\Enums\DateTime\Zone $zone <p>
     * The timezone identifier.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\DateTime\FailedToSetZoneError If failed to set the default
     * timezone.
     *
     * @return true Always true.
     */
    public static function setDefaultTimezone (Zone $zone):true {

        return date_default_timezone_set($zone->value)
            ?: throw new FailedToSetZoneError;

    }

    /**
     * ### Get an associative array containing dst, offset, and the timezone name alias
     * @since 1.0.0
     *
     * @return array<string, list<array{
     *   dst: bool,
     *   offset: int,
     *   timezone_id: string|null
     * }>> List of timezone abbreviations.
     */
    public static function abbreviationList ():array {

        return timezone_abbreviations_list();

    }

}