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

namespace FireHub\Core\Support\Autoload;

/**
 * ### Autoload Loader Interface
 *
 * Defines the contract for all autoloader implementations within the FireHub framework.<br>
 * Any loader (PSR-4, ClassMap, Cache, etc.) must implement this interface to provide a consistent method for
 * locating and loading PHP classes on demand.<br>
 * Implementations should handle the logic for resolving a fully qualified class name to its corresponding file path
 * and include it if necessary.
 * @since 1.0.0
 */
interface Loader {

    /**
     * ### Invoke autoload function being registered
     * @since 1.0.0
     *
     * @param string $class <p>
     * Fully qualified class name that is being loaded.
     * </p>
     *
     * @return void
     */
    public function __invoke (string $class):void;

}