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
 */

namespace FireHub\Core\Shared\Enums;

/**
 * ### Mutation outcome enum
 * @since 1.0.0
 */
enum MutationOutcome {

    /**
     * ### New Entry Created
     * @since 1.0.0
     */
    case CREATED;

    /**
     * ### Existing Entry Updated
     * @since 1.0.0
     */
    case UPDATED;

    /**
     * ### Entry Removed
     * @since 1.0.0
     */
    case REMOVED;

    /**
     * ### Entry Not Found
     * @since 1.0.0
     */
    case NOT_FOUND;

}