<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.1
 * @package Core\Shared
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Shared\Enums\DateTime\Format;

/**
 * ### Predefined date/time formats
 *
 * Enum representing commonly used date/time formats in PHP.
 * @since 1.0.0
 *
 * @api
 */
enum Predefined:string {

    /**
     * ### Date-only format
     *
     * <code>
     *   2022-12-09
     * </code>
     * @since 1.0.0
     */
    case DATE = '!Y-m-d';

    /**
     * ### Time-only format
     *
     * <code>
     *   08:53:18
     * </code>
     */
    case TIME = 'H:i:s';

    /**
     * ### Time-only format with microseconds
     *
     * <code>
     *   08:53:56.844337
     * </code>
     * @since 1.0.0
     */
    case MICRO_TIME = 'H:i:s.u';

    /**
     * ### Date and time format
     *
     * <code>
     *   2022-12-09 08:55:00
     * </code>
     * @since 1.0.0
     */
    case DATETIME = 'Y-m-d H:i:s';

    /**
     * ### Date and time format with microseconds
     *
     * <code>
     *   2022-12-09 08:55:33.641682
     * </code>
     * @since 1.0.012-09 08:55:33.641682
     */
    case DATE_MICRO_TIME = 'Y-m-d H:i:s.u';

    /**
     * ### ATOM
     *
     * <code>
     *   2022-12-09T08:58:56+01:00
     * </code>
     * @since 1.0.0
     */
    case ATOM = 'Y-m-d\TH:i:sP';

    /**
     * ### ATOM_EXTENDED
     *
     * <code>
     *   2022-12-09T08:58:45.038+01:00
     * </code>
     * @since 1.0.0
     */
    case ATOM_EXTENDED = 'Y-m-d\TH:i:s.vP';

    /**
     * ### COOKIE
     *
     * <code>
     *   Friday, 09-Dec-2022 08:58:31 CET
     * </code>
     * @since 1.0.0
     */
    case COOKIE = 'l, d-M-Y H:i:s T';

    /**
     * ### ISO8601
     *
     * <code>
     *   022-12-09T08:58:18+0100
     * </code>
     * @since 1.0.012-09T08:58:18+0100
     * ```
     */
    case ISO8601 = 'Y-m-d\TH:i:sO';

    /**
     * ### ISO8601_EXPANDED
     *
     * <code>
     *   X-12-09T08:58:03+01:00
     * </code>
     * @since 1.0.0
     */
    case ISO8601_EXPANDED = 'X-m-d\TH:i:sP';

    /**
     * ### RFC822
     *
     * <code>
     *   Fri, 09 Dec 22 08:57:30 +0100
     * </code>
     * @since 1.0.0
     */
    case RFC822 = 'D, d M y H:i:s O';

    /**
     * ### RFC850
     *
     * <code>
     *   Friday, 09-Dec-22 08:57:46 CET
     * </code>
     * @since 1.0.0
     */
    case RFC850 = 'l, d-M-y H:i:s T';

    /**
     * ### RFC7231
     *
     * <code>
     *   Fri, 09 Dec 2022 08:56:35 GMT
     * </code>
     * @since 1.0.0
     */
    case RFC7231 = 'D, d M Y H:i:s \G\M\T';

    /**
     * ### RSS
     *
     * <code>
     *   Fri, 09 Dec 2022 08:56:11 +0100
     * </code>
     * @since 1.0.0
     */
    case RSS = 'D, d M Y H:i:s O';

}