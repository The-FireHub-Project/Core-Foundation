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

namespace FireHub\Core\Shared\Enums\SystemRuntime;

/**
 * ### PHP INI Directive Access Level
 *
 * Enum representing the access level of PHP configuration directives.<br>
 * Wraps the integer `access` value returned by `ini_get_all()` into a type-safe enum.
 * @since 1.0.0
 *
 * @api
 */
enum IniAccessLevel:int {

    /**
     * ### Entry can be set in user scripts (like with ini_set()), in the Windows registry, or in .user.ini
     * @since 1.0.0
     */
    case USER = 1;

    /**
     * ### Entry can be set in php.ini, .htaccess, httpd.conf, or .user.ini
     * @since 1.0.0
     */
    case PER_DIR = 2;

    /**
     * ### Entry can be set in user scripts (like with ini_set()), in the Windows registry, or in .user.ini, php.ini, .htaccess, or httpd.conf
     * @since 1.0.0
     */
    case USER_AND_PER_DIR = 3;

    /**
     * ### Entry can be set in php.ini or httpd.conf
     * @since 1.0.0
     */
    case SYSTEM = 4;

    /**
     * ### Entry can be set in user scripts (like with ini_set()), in the Windows registry, or in .user.ini, php.ini, or httpd.conf
     * @since 1.0.0
     */
    case USER_AND_SYSTEM = 5;

    /**
     * ### Entry can be set in user scripts (like with ini_set()), in the Windows registry, or in .user.ini, php.ini, .htaccess, or httpd.conf
     * @since 1.0.0
     */
    case PER_DIR_AND_SYSTEM = 6;

    /**
     * ### Entry can be set anywhere
     * @since 1.0.0
     */
    case ALL = 7;

}