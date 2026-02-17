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

namespace FireHub\Core\Shared\Enums\Json\Flag;

/**
 * ### Enums flags for validate functions
 * @since 1.0.0
 *
 * @api
 */
enum Validate:int {

    /**
     * ### Ignore invalid UTF-8 characters
     * @since 1.0.0
     */
    case INVALID_UTF8_IGNORE = 1048576;

}