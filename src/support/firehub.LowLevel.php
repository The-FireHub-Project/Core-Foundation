<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support;

/**
 * ### Abstract Low-Level Base Class
 *
 * Serves as the base class for all low-level helper classes in the FireHub framework.<br>
 * Provides a private and final constructor to prevent instantiation and overriding, enforcing a stateless,
 * static-only usage pattern.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
abstract class LowLevel {

    /**
     * ### Protected and final constructor to prevent instantiation and overriding
     * @since 1.0.0
     *
     * @return void
     */
    final protected function __construct() {}

}