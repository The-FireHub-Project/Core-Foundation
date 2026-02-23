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
 * ### Sorting order enum
 *
 * Represents the direction in which items should be ordered.<br>
 * Used in sorting functions to specify ascending (ASC) or descending (DESC) order.<br>
 * Provides a convenient method to reverse the current order.
 * @since 1.0.0
 *
 * @api
 */
enum Order:string {

    /**
     * ### Ascending order
     *
     * Represents sorting in ascending order (smallest to largest).<br>
     * Used in sorting functions to specify that items should be ordered from lowest to highest.
     * @since 1.0.0
     */
    case ASC = 'ASC';

    /**
     * ### Descending order
     *
     * Represents sorting in descending order (largest to smallest).<br>
     * Used in sorting functions to specify that items should be ordered from highest to lowest.
     * @since 1.0.0
     */
    case DESC = 'DESC';

    /**
     * ### Get the reverse order
     * @since 1.0.0
     *
     * @return \FireHub\Core\Shared\Enums\Order Reversed order.
     */
    public function reverse ():self {

        return match ($this) {
            self::ASC => self::DESC,
            default => self::ASC
        };

    }

}