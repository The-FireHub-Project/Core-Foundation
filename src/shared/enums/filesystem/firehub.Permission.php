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

namespace FireHub\Core\Shared\Enums\FileSystem;

/**
 * ### File or folder permission enum
 *
 * Represents a single permission digit (0–7) for owner, group, or global access.
 * @since 1.0.0
 *
 * @api
 */
enum Permission:int {

    /**
     * ### User has no permissions
     * @since 1.0.0
     */
    case NOTHING = 0;

    /**
     * ### User with permissions to execute a file as a program
     * @since 1.0.0
     */
    case EXECUTE = 1;

    /**
     * ### Grants the ability to modify or remove the content of the file
     * @since 1.0.0
     */
    case WRITE = 2;

    /**
     * ### Combination of writing and execute permissions
     * @since 1.0.0
     */
    case WRITE_EXECUTE = 3;

    /**
     * ### Grants the ability to read, in other words, view the contents of the file
     * @since 1.0.0
     */
    case READ = 4;

    /**
     * ### Combination of read and execute permissions
     * @since 1.0.0
     */
    case READ_EXECUTE = 5;

    /**
     * ### Combination of read and write permissions
     * @since 1.0.0
     */
    case READ_WRITE = 6;

    /**
     * ### User has all permissions: read, write, and execute
     * @since 1.0.0
     */
    case ALL = 7;

}