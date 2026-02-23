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

namespace FireHub\Core\Shared\Enums;

/**
 * ### Standard PHP comparison operators
 *
 * This enum represents all the common comparison operators in PHP, including equality, identity, relational,
 * and the spaceship operator.<br>
 * It can be used for type-safe comparisons in low-level and high-level helpers throughout the FireHub framework.
 * @since 1.0.0
 *
 * @api
 */
enum Comparison:string {

    /**
     * ### True if $a is equal to $b after type juggling
     * @since 1.0.0
     */
    case EQUAL = '==';

    /**
     * ### True if $a is equal to $b, and they're of the same type
     * @since 1.0.0
     */
    case IDENTICAL = '===';

    /**
     * ### True if $a is not equal to $b after type juggling
     * @since 1.0.0
     */
    case NOT_EQUAL = '!=';

    /**
     * ### True if $a is not equal to $b, or they aren't of the same type
     * @since 1.0.0
     */
    case NOT_IDENTICAL = '!==';

    /**
     * ### True if $a is strictly less than $b
     * @since 1.0.0
     */
    case LESS = '<';

    /**
     * ### True if $a is strictly greater than $b
     * @since 1.0.0
     */
    case GREATER = '>';

    /**
     * ### True if $a is less than or equal to $b
     * @since 1.0.0
     */
    case LESS_OR_EQUAL = '<=';

    /**
     * ### True if $a is greater than or equal to $b
     * @since 1.0.0
     */
    case GREATER_OR_EQUAL = '>=';

    /**
     * ### An int less than, equal to, or greater than zero when $a is less than, equal to, or greater than $b, respectively
     * @since 1.0.0
     */
    case SPACESHIP = '<=>';

}