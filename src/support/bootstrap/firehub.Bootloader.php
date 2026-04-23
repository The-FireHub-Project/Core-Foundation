<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core
 */

namespace FireHub\Core\Support\Bootstrap;

/**
 * ### Core Runtime Initialization Contract
 *
 * Contract for all bootstrap components in the FireHub framework.<br>
 * It ensures that each bootloader provides a standardized method to initialize specific runtime elements before the
 * application Kernel executes.
 * @since 1.0.0
 */
interface Bootloader {

    /**
     * ### Execute Bootloader Initialization
     * @since 1.0.0
     *
     * @return bool True if the bootloader was loaded successfully, false otherwise.
     */
    public function boot ():bool;

}